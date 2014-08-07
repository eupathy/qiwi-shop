<?php

return array(
	'user_id' => Auth::user() ? Auth::user()->getAuthIdentifier() : null,

	/*'provider' => array(
		'name'     => 'Fintech-Fab',
		'id'       => '',
		'password' => '',
		'key'      => '',
	),



	'lifetime' => 3, // Срок действия заказа в днях

	'gateUrl'  => '',
	'payUrl'   => '',*/

);