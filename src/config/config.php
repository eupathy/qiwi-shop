<?php

return array(

	'provider' => array(
		'name'     => 'Fintech-Fab',
		'id'       => '',
		'password' => '',
		'key'      => '',
	),

	'user_id'  => Auth::user() ? Auth::user()->getAuthIdentifier() : null,

	'lifetime' => 3, // Срок действия заказа в днях

	'gateUrl'  => '',
	'payUrl'   => '',

);