<?php

Route::group(array(
	'before'    => 'ff.qiwi.shop.checkUser',
	'prefix'    => 'qiwi/shop/orders',
	'namespace' => 'FintechFab\QiwiShop\Controllers'
), function () {

	Route::get('/', array(
		'as'   => 'qiwiShop_ordersTable',
		'uses' => 'OrderController@ordersTable',
	));

	Route::get('/create', array(
		'as'   => 'qiwiShop_createOrder',
		'uses' => 'OrderController@createOrder',
	));
	Route::post('/create', array(
		'as'   => 'qiwiShop_postCreateOrder',
		'uses' => 'OrderController@postCreateOrder',
	));
	Route::post('/action/{action}', array(
		'as'   => 'qiwiShop_actionsOrdersTable',
		'uses' => 'OrderController@getAction',
	));
	Route::get('/authError', array(
		'as'   => 'qiwiShop_AuthError',
		'uses' => 'OrderController@authError',
	));
});


Route::post('/qiwi/shop/orders/callback', array(
	'as'   => 'qiwiShop_processCallback',
	'uses' => 'FintechFab\QiwiShop\Controllers\OrderController@processCallback',
));

Route::get('qiwi/shop/orders/about', array(
	'as'   => 'qiwiShop_about',
	'uses' => 'FintechFab\QiwiShop\Controllers\OrderController@about',
));

Route::get('qiwi/shop/orders/aboutSdk', array(
	'as'   => 'qiwiShop_aboutSdk',
	'uses' => 'FintechFab\QiwiShop\Controllers\OrderController@aboutSdk',
));


