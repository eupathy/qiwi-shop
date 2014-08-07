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

		$_SERVER['HTTP_X_API_SIGNATURE'] = $sign;


		$resp = $this->call(
			'POST',
			URL::route('qiwiShop_processCallback'),
			$bill
		);

		$this->assertContains('<?xml version="1.0"?><result><result_code>0</result_code></result>', $resp->original);
	}

	public function testReceiveCallbackSignFail()
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
		$key = Config::get('ff-qiwi-shop::provider.key') . 123;
		$signData = $bill['amount'] . '|' . $bill['bill_id'] . '|' . $bill['ccy'] . '|' . $bill['command'] . '|' .
			$bill['comment'] . '|' . $bill['error'] . '|' . $bill['prv_name'] . '|' . $bill['status'] . '|' . $bill['user'];
		$sign = base64_encode(hash_hmac('sha1', $signData, $key));

		$_SERVER['HTTP_X_API_SIGNATURE'] = $sign;

		$resp = $this->call(
			'POST',
			URL::route('qiwiShop_processCallback'),
			$bill
		);

		$this->assertContains('<?xml version="1.0"?><result><result_code>150</result_code></result>', $resp->original);
	}

	public function testReceiveCallbackBillFail()
	{
		$bill = array(
			'bill_id'  => '15',
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

		$_SERVER['HTTP_X_API_SIGNATURE'] = $sign;

		$resp = $this->call(
			'POST',
			URL::route('qiwiShop_processCallback'),
			$bill
		);

		$this->assertContains('<?xml version="1.0"?><result><result_code>210</result_code></result>', $resp->original);
	}

}