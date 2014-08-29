<?php
namespace FintechFab\QiwiShop\Controllers;

use App;
use Config;
use FintechFab\QiwiSdk\Curl;
use FintechFab\QiwiSdk\Gateway;
use FintechFab\QiwiShop\Components\Dictionary;
use FintechFab\QiwiShop\Components\PaysReturn;
use FintechFab\QiwiShop\Components\Validators;
use FintechFab\QiwiShop\Models\Order;
use FintechFab\QiwiShop\Models\PayReturn;
use FintechFab\QiwiShop\Models\Setting;
use Input;
use Log;
use Validator;

class OrderController extends BaseController
{

	public $layout = 'order';

	//Передаём настройки в Gateway
	public function __construct()
	{
		$oSettings = Setting::find(Config::get('ff-qiwi-shop::user_id'));
		$this->setConfigForGateway($oSettings);
	}

	//Определяем метод по $action переданному в url
	public function getAction($action)
	{
		//Получаем заказ по id пользователя и номеру заказа
		$order_id = Input::get('order_id');
		$order = Order::whereUserId(Config::get('ff-qiwi-shop::user_id'))
			->find($order_id);

		if (!$order) {
			return $this->resultMessage('Нет такого заказа');
		}

		// вызываем метод по названию переменной (data-action кнопки на странице)
		return $this->$action($order);
	}

	/**
	 * Страница таблицы заказов
	 *
	 * @return void
	 */
	public function ordersTable()
	{
		$user_id = Config::get('ff-qiwi-shop::user_id');
		$orders = Order::whereUserId($user_id)
			->orderBy('id', 'desc')
			->paginate(10);
		$setting = Setting::find($user_id);
		$this->make('ordersTable', array('orders' => $orders, 'settings' => $setting));
	}

	/**
	 * Создание счёта.
	 *
	 * @return array
	 */
	public function postCreateOrder()
	{
		$data = Input::all();
		//Проверяем данные на валидность
		$validator = Validator::make(
			$data,
			Validators::rulesForNewOrder(),
			Validators::messagesForErrors()
		);
		$userMessages = $validator->messages();

		//Если есть ошибки, возвращаем
		if ($validator->fails()) {
			$result['errors'] = array(
				'item'    => $userMessages->first('item'),
				'sum'     => $userMessages->first('sum'),
				'tel'     => $userMessages->first('tel'),
				'comment' => $userMessages->first('comment'),
			);

			return $result;
		}
		//Предполагаем ошибку
		$result['errors'] = array(
			'common' => 'Ошибка. Повторите ещё раз.',
		);

		//Создаём заказ
		$data['user_id'] = Config::get('ff-qiwi-shop::user_id');
		$validity = Setting::find($data['user_id'])->lifetime;
		$data['lifetime'] = date('Y-m-d H:i:s', time() + 3600 * 24 * $validity);

		$order = new Order();
		$order->saveData($data);

		//Если заказ создан, то вместо ошибки отдаём ОК
		if ($order) {
			$result = array(
				'result'   => 'ok',
				'order_id' => $order->id,
				'message'  => 'Заказ №' . $order->id . ' успешно создан.',
			);
		}

		return $result;
	}

	/**
	 * Проверка статуса счёта.
	 *
	 * @param Order $order
	 *
	 * @return array
	 */
	public function showStatus($order)
	{
		$gate = new Gateway($this->makeCurl());
		$isSuccess = $gate->doRequestBillStatus($order->id);

		if ($isSuccess) {
			$order->changeStatus($gate->getValueBillStatus());

			$message = 'Текущий статус счета - '
				. Dictionary::statusRussian($order->status);

			return $this->resultMessage($message, 'Сообщение');

		}

		return $this->resultMessage($gate->getError());
	}

	/**
	 * Выставление счёта
	 *
	 * @param Order $order
	 *
	 * @return array
	 */
	public function createBill($order)
	{
		if (!$order->isNew()) {
			return $this->resultMessage('Статус заказа не "Новый"');
		}

		$gate = new Gateway($this->makeCurl());
		$isSuccess = $gate->createBill(
			$order->id, $order->tel, $order->sum, $order->comment, $order->lifetime
		);

		if (!$isSuccess) {
			return $this->resultMessage($gate->getError());
		}
		$order->changeStatus(Order::C_ORDER_STATUS_PAYABLE);

		if ($order->status == Order::C_ORDER_STATUS_PAYABLE) {
			$message = 'Счёт выставлен';

			return $this->resultMessage($message, 'Сообщение');
		}

		return $this->resultMessage('Счёт не выставлен');
	}

	/**
	 * Отменить счёт.
	 *
	 * @param Order $order
	 *
	 * @return array
	 */
	public function cancelBill($order)
	{
		$gate = new Gateway($this->makeCurl());
		$isSuccess = $gate->cancelBill($order->id);
		if (!$isSuccess) {
			return $this->resultMessage($gate->getError());
		}
		$order->changeStatus(Order::C_ORDER_STATUS_CANCELED);

		if ($order->status == Order::C_ORDER_STATUS_CANCELED) {
			$message = 'Счёт отменён.';

			return $this->resultMessage($message, 'Сообщение');
		}

		return $this->resultMessage('Счёт не отменён');
	}

	/**
	 * Возврат оплаты
	 *
	 * @param Order $order
	 *
	 * @return array
	 */
	public function payReturn($order)
	{
		$data = Input::all();

		//Проверяем данные на валидность и возвращаем если ошибка
		$validator = Validator::make(
			$data,
			Validators::rulesForPayReturn(),
			Validators::messagesForErrors()
		);
		$userMessages = $validator->messages();

		if ($validator->fails()) {
			$result['error'] = array(
				'sum'     => $userMessages->first('sum'),
				'comment' => $userMessages->first('comment'),
			);

			return $result;
		}

		//Возможен ли возврат указанной суммы,
		//учитывая прошлые возвраты по этому счёту
		$isAllowedSum = PaysReturn::isAllowedSum($order, $data['sum']);

		if (!$isAllowedSum) {
			$result['error'] = array(
				'sum' => 'Слишком большая сумма',
			);

			return $result;
		}

		//Если не закончен придыдущий возврат, то не даём сделать новый
		if ($order->isOnReturn()) {
			return $this->resultMessage('Дождитесь окончания предыдущего возврата.');
		}

		//Создаём возврат в таблице и начинаем возврат
		$payReturn = PaysReturn::newPayReturn($data);
		if (!$payReturn) {
			return $this->resultMessage('Возврат не создан, повторите попытку.');
		}
		$gate = new Gateway($this->makeCurl());
		$isSuccess = $gate->payReturn($payReturn->order_id, $payReturn->id, $payReturn->sum);

		//Если ошибка, то удаляем наш возврат из таблицы
		if (!$isSuccess) {
			PayReturn::find($payReturn->id)->delete();

			return $this->resultMessage($gate->getError());
		}

		//Меняем статус заказа при успешном возврате
		$order->changeAfterReturn($payReturn->id);
		$message = 'Сумма ' . $data['sum'] .
			' руб. по счёту № ' . $order->id . ' отправлена на возврат';

		return $this->resultMessage($message, 'Сообщение');

	}

	/**
	 * Проверка статуса возврат оплаты
	 *
	 * @param Order $order
	 *
	 * @return array
	 */
	public function statusReturn($order)
	{
		$payReturn = PayReturn::find($order->idLastReturn);
		if (!$payReturn) {
			return $this->resultMessage('Нет такого возврата');
		}

		$gate = new Gateway($this->makeCurl());
		$isSuccess = $gate->doRequestReturnStatus($payReturn->order_id, $payReturn->id);
		if (!$isSuccess) {
			return $this->resultMessage($gate->getError());
		}
		$newReturnStatus = $payReturn->changeStatus($gate->getValuePayReturnStatus());

		$message = 'Текущий статус возврата - '
			. Dictionary::statusRussian($newReturnStatus);

		return $this->resultMessage($message, 'Сообщение');

	}

	/**
	 * Обработка callback запроса
	 *
	 * @return string
	 */
	public function processCallback()
	{
		$provider = $this->getProvider();
		$oSettings = Setting::whereGateId($provider['login'])->first();
		$this->setConfigForGateway($oSettings);

		$requestParams = Input::all();
		Log::info('Получены параметры в qiwi-shop для обработки callback:', array(
			'$requestParams' => $requestParams,
			'$provider'      => $provider,
		));
		$gate = new Gateway($this->makeCurl());
		if ($gate->doParseCallback($requestParams)) {
			$order = Order::find($gate->getCallbackOrderId());
			if (!$order) {
				$gate->createCallbackResponse(Gateway::C_BILL_NOT_FOUND);

				return $gate->doCallbackResponse();
			}
			$newStatus = $gate->getValueBillStatus();
			Log::info('Статусы заказов после обработки callback:', array(
				'oldStatus' => $order->status,
				'newStatus' => $newStatus,
			));
			if ($order->status != $newStatus) {
				$order->status = $newStatus;
				$order->save();
			}
		}

		return $gate->doCallbackResponse();
	}

	/**
	 * @param string $messages
	 * @param string $title
	 *
	 * @return array
	 */
	private function resultMessage($messages, $title = 'Ошибка')
	{
		$result['message'] = $messages;
		$result['title'] = $title;

		return $result;
	}

	/**
	 * @return Curl
	 */
	private function makeCurl()
	{
		return App::make('FintechFab\QiwiSdk\Curl');
	}


	/**
	 * Получить логин:пароль из заголовка callback`а
	 *
	 * @return array|null
	 */
	private function getProvider()
	{
		if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
			$authBasicHeader = trim($_SERVER['HTTP_AUTHORIZATION']);

			preg_match('/^Basic (.+)$/', $authBasicHeader, $matches);
			@list($login, $password) = explode(':', base64_decode($matches[1]));
			$providerData = array(
				'login'    => $login,
				'password' => $password,
			);

			return $providerData;
		}

		return null;
	}

	/**
	 * @param Setting $oSettings
	 */
	private function setConfigForGateway($oSettings)
	{
		if ($oSettings == null) {
			return;
		}
		$config = array(
			'gateUrl'  => $oSettings->gate_url,
			'provider' => array(
				'id'       => $oSettings->gate_id,
				'password' => $oSettings->gate_password,
				'name'     => $oSettings->name,
				'key'      => $oSettings->gate_key,
			),
		);
		Gateway::setConfig($config);
	}
}
