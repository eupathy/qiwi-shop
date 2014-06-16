<?php

use FintechFab\QiwiShop\Models\Order;

class ReceiveCallbackTest extends ShopTestCase
{

	public function setUp()
	{
		parent::setUp();

		Order::truncate();
		$order = new Order();
		$order->create(array(
			'user_id'  => 1,
			'item'     => 'New Lamp',
			'sum'      => 150,
			'tel'      => '+12345',
			'comment'  => '',
			'status'   => 'payable',
			'lifetime' => date('Y-m-d H:i:s', time()),

		));

	}

	public function testReceiveCallback()
	{
		$bill = array(
			'bill_id'  => '1',
			'status'   => 'waiting',
			'error'    => 0,
			'amount'   => 150,
			'user'     => '+12345',
			'prv_name' => 'Fintech-fab',
			'ccy'      => 'RUB',
			'comment'  => '',
			'command'  => 'bill',
		);
		$key = Config::get('ff-qiwi-shop::provider.key');
		$signData = $bill['amount'] . '|' . $bill['bill_id'] . '|' . $bill['ccy'] . '|' . $bill['command'] . '|' .
			$bill['comment'] . '|' . $bill['error'] . '|' . $bill['prv_name'] . '|' . $bill['status'] . '|' . $bill['user'];
		$sign = base64_encode(hash_hmac('sha1', $signData, $key));
		$resp = $this->call(
			'POST',
			URL::route('processCallback'),
			$bill,
			array(),
			array(
				'HTTP_X-Api-Signature' => $sign
			)
		);
		dd($resp);

	}

}