<?php

Route::group(array(
	'before'    => 'ff.qiwi.shop.checkUser',
	'prefix'    => 'qiwi/shop',
	'namespace' => 'FintechFab\QiwiShop\Controllers'
), function () {

	Route::get('/settings', array(
		'as'   => 'qiwiShop_settings',
		'uses' => 'QiwiShopController@settings',
	));
	Route::post('/settings', array(
		'as'   => 'qiwiShop_settings',
		'uses' => 'QiwiShopController@postSettings',
	));
	Route::get('/orders', array(
		'as'   => 'qiwiShop_ordersTable',
		'uses' => 'OrderController@ordersTable',
	));

	Route::post('/orders/create', array(
		'as'   => 'qiwiShop_postCreateOrder',
		'uses' => 'OrderController@postCreateOrder',
	));
	Route::post('/orders/action/{action}', array(
		'as'   => 'qiwiShop_actionsOrdersTable',
		'uses' => 'OrderController@getAction',
	));
	Route::get('/authError', array(
		'as'   => 'qiwiShop_AuthError',
		'uses' => 'QiwiShopController@authError',
	));
});


Route::post('/qiwi/shop/callback', array(
	'as'   => 'qiwiShop_processCallback',
	'uses' => 'FintechFab\QiwiShop\Controllers\OrderController@processCallback',
));

Route::get('qiwi/shop/about', array(
	'as'   => 'qiwiShop_about',
	'uses' => 'FintechFab\QiwiShop\Controllers\QiwiShopController@about',
));

Route::get('qiwi/shop/aboutSdk', array(
	'as'   => 'qiwiShop_aboutSdk',
	'uses' => 'FintechFab\QiwiShop\Controllers\QiwiShopController@aboutSdk',
));


