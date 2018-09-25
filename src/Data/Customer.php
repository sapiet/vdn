<?php

namespace App\Data;

class Customer
{
	const LIST = [
		[
			'firstname' => 'Xavier',
			'lastname' => 'Quièvre',
			'address' => '7 allée des Coutilliers',
			'suburb' => '',
			'zipcode' => '59700',
			'city' => 'Marcq-en-Baroeul',
			'subscriptions' => ['vdn', 'vdn2', 'vds']
		],[
			'firstname' => 'Sandra',
			'lastname' => 'Vanhove',
			'address' => '7 allée des Coutilliers',
			'suburb' => '',
			'zipcode' => '59700',
			'city' => 'Marcq-en-Baroeul',
			'subscriptions' => ['vdn']
		],[
			'firstname' => 'Christine',
			'lastname' => 'Quièvre',
			'address' => '11 rue des Enseignes',
			'suburb' => '',
			'zipcode' => '59700',
			'city' => 'Marcq-en-Baroeul',
			'subscriptions' => ['vds']
		],[
			'firstname' => 'Robert',
			'lastname' => '',
			'address' => '',
			'suburb' => '',
			'zipcode' => '59700',
			'city' => 'Marcq-en-Baroeul',
			'subscriptions' => []
		]
	];
}
