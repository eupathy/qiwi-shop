<?php

Route::group(array(
	'before'    => 'ff.qiwi.shop.checkUser',
	'prefix'    => 'qiwi/shop/orders',
	'namespace' => 'FintechFab\QiwiShop\Controllers'
), function () {

	Route::get('/', array(
		'as'   => 'ordersTable',
		'uses' => 'OrderController@ordersTable',
	));

	Route::get('/create', array(
		'as'   => 'createOrder',
		'uses' => 'OrderController@createOrder',
	));
	Route::post('/create', array(
		'as'   => 'postCreateOrder',
		'uses' => 'OrderController@postCreateOrder',
	));
	Route::post('/{action}', array(
		'as'   => 'actionsOrdersTable',
		'uses' => 'OrderController@getAction',
	));
	Route::get('/authError', array(
		'as'   => 'shopAuthError',
		'uses' => 'OrderController@authError',
	));
});


Route::post('/qiwi/shop/orders', array(
	'as'   => 'processCallback',
	'uses' => 'FintechFab\QiwiShop\Controllers\OrderController@processCallback',
));


