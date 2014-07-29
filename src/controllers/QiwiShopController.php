<?php

namespace FintechFab\QiwiShop\Controllers;


use Config;
use FintechFab\QiwiShop\Components\Validators;
use FintechFab\QiwiShop\Models\Setting;
use Input;
use Validator;

class QiwiShopController extends BaseController
{

	public $layout = 'qiwiShop';

	/**
	 * Страница ошибки авторизации
	 */
	public function authError()
	{
		return $this->make('authError');
	}

	/**
	 * Страница описания эмулятора магазина
	 */
	public function about()
	{
		return $this->make('about');
	}

	/**
	 * Страница описания SDK для работы с qiwi-gate
	 */
	public function aboutSdk()
	{
		return $this->make('aboutSdk');
	}

	/**
	 * Страница внесения настроек
	 */
	public function settings()
	{
		$user_id = Config::get('ff-qiwi-shop::user_id');
		$setting = Setting::whereUserId($user_id)->first();
		if ($setting == null) {
			return $this->make('setSettings', array('user_id' => $user_id));
		}

		return $this->make('changeSettings', array('setting' => $setting));
	}

	public function postSettings()
	{
		$data = Input::only('name', 'gateId', 'password', 'key', 'lifetime', 'gateUrl', 'payUrl');
		$validate = Validator::make(
			$data,
			Validators::rulesForSetting(),
			Validators::messagesForErrors()
		);
		$userMessages = $validate->messages();

		if ($validate->fails()) {
			$result['errors'] = array(
				'name'     => $userMessages->first('name'),
				'gateId'   => $userMessages->first('gateId'),
				'password' => $userMessages->first('password'),
				'key'      => $userMessages->first('key'),
				'lifetime' => $userMessages->first('lifetime'),
				'gateUrl'  => $userMessages->first('gateUrl'),
				'payUrl'   => $userMessages->first('payUrl'),
			);

			return $result;
		}
		$data['user_id'] = Config::get('ff-qiwi-shop::user_id');
		$setting = Setting::whereUserId($data['user_id'])->first() != null
			? Setting::whereUserId($data['user_id'])->first()
			: new Setting();
		$setting->newSetting($data);

		return array('message' => 'Настройки сохранены');

	}
}
