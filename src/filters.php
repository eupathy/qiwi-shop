<?php
Route::filter('ff.qiwi.shop.checkUser', function () {

	$routeError = 'shopAuthError';
	$routeAction = Route::current()->getAction();
	$isErrorPage = $routeError == $routeAction['as'];

	$user = Config::get('ff-qiwi-shop::user_id');
	if ($user <= 0) {

		if (!$isErrorPage) {
			return Redirect::route($routeError);
		}
	} elseif ($isErrorPage) {
		return Redirect::route('ordersTable');
	}

});