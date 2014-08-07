<?php

use FintechFab\QiwiShop\Models\Order;
use FintechFab\QiwiShop\Models\Setting;
use Illuminate\Auth\UserInterface;

class ShopTestCase extends TestCase
{


	public function setUp()
	{
		parent::setUp();

		/**
		 * @var UserInterface|Mockery\MockInterface $mock
		 */
		$mock = Mockery::mock('Illuminate\Auth\UserInterface');
		$mock->shouldReceive('getAuthIdentifier')->andReturn(5);
		Auth::login($mock);

		Order::truncate();
		Setting::truncate();
		Setting::create(array(
			'id'            => 1,
			'name'          => 'Fintech-fab',
			'lifetime'      => 3,
			'gate_id'       => 1,
			'gate_password' => 1234,
			'gate_key'      => 'key',
			'gate_url'      => 'http://fintech-fab.dev/qiwi/gate/api/v2/prv/',
			'pay_url'       => 'http://fintech-fab.dev:8000/qiwi/gate/order/external/main.action',
		));
		Config::set('ff-qiwi-shop::user_id', 1);
		Config::set('gateUrl', 'http://fintech-fab.dev/qiwi/gate/api/v2/prv/');
		Config::set('ff-qiwi-shop::provider.id', 1);
		Config::set('ff-qiwi-shop::provider.password', 1234);
		Config::set('ff-qiwi-shop::provider.name', 'Fintech-fab');
		Config::set('ff-qiwi-shop::provider.key', 'key');

		Config::set('ff-qiwi-shop::testConfig.testUrl', 'http://fintech-fab-test.dev:8080/qiwi/shop/orders');
	}

}