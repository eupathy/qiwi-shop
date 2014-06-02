<?php

return array(

	'provider' => array(
		'name'     => 'Fintech-Fab',
		'id'       => '',
		'password' => '',
	),

	'user_id'  => Auth::user() ? Auth::user()->getAuthIdentifier() : null,

	'lifetime' => 3, // Срок действия заказа в днях

	'gateUrl'  => 'http://fintech-fab.dev/qiwi/gate/api/v2/prv/',

);