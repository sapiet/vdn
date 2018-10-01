<?php

namespace App\Data;

class Customer
{
	const LIST = [
		[
			'name' => 'Mme LEVY JOSE',
			'address' => '61, rue Raymond Derain',
			'suburb' => '',
			'zipcode' => '59700',
			'city' => 'Marcq-en-Baroeul',
			'subscriptions' => [
				'vdn' => [],
				'tv' => [],
				'fem' => [],
			],
		],[
			'name' => 'Mr VAN PRAET',
			'address' => '317 rue Fouquet Lelong',
			'suburb' => '',
			'zipcode' => '59700',
			'city' => 'Marcq-en-Baroeul',
			'subscriptions' => [
				'vdn' => ['days' => [0, 6]],
				'fem' => [],
			],
		],[
			'name' => 'Mr CACHOT Jean',
			'address' => '335 rue Fouquet Lelong',
			'suburb' => '',
			'zipcode' => '59700',
			'city' => 'Marcq-en-Baroeul',
			'subscriptions' => [
				'vdn' => ['days' => [0, 5, 6]],
				'tv' => [],
				'fem' => [],
			],
		],[
			'name' => 'Mr DE RYCKE',
			'address' => '54 Avenue De Lattre de Tassigny',
			'suburb' => '',
			'zipcode' => '59700',
			'city' => 'Marcq-en-Baroeul',
			'subscriptions' => [
				'vdn' => [],
				'tv' => [],
				'fem' => [],
			],
		],[
			'name' => 'Mr MESSAGER Gérard',
			'address' => '218 Avenue De Lattre de Tassigny',
			'suburb' => '',
			'zipcode' => '59700',
			'city' => 'Marcq-en-Baroeul',
			'subscriptions' => [
				'vdn' => [],
				'tv' => [],
				'fem' => [],
			],
		],[
			'name' => 'Mr DEVAUX Jean Michel',
			'address' => '236 Avenue De Lattre de Tassigny',
			'suburb' => '',
			'zipcode' => '59700',
			'city' => 'Marcq-en-Baroeul',
			'subscriptions' => [
				'vdn' => [],
				'tv' => [],
				'fem' => [],
			],
		],[
			'name' => 'Mr PELLUAULT',
			'address' => '268 Avenue De Lattre de Tassigny',
			'suburb' => '',
			'zipcode' => '59700',
			'city' => 'Marcq-en-Baroeul',
			'subscriptions' => [
				'vdn' => [],
				'tv' => [],
				'fem' => [],
			],
		],[
			'name' => 'Mr BAROIS',
			'address' => '281 Avenue De Lattre de Tassigny',
			'suburb' => '',
			'zipcode' => '59700',
			'city' => 'Marcq-en-Baroeul',
			'subscriptions' => [
				'vdn' => [],
				'tv' => [],
				'fem' => [],
			],
		],[
			'name' => 'Mr SELOSSE',
			'address' => '17 rue du Grand Pavois',
			'suburb' => '',
			'zipcode' => '59700',
			'city' => 'Marcq-en-Baroeul',
			'subscriptions' => [
				'vdn' => [],
				'tv' => [],
				'fem' => [],
			],
		],[
			'name' => 'Mr DECLINCOURT Marcel',
			'address' => '287 Avenue De Lattre de Tassigny',
			'suburb' => '',
			'zipcode' => '59700',
			'city' => 'Marcq-en-Baroeul',
			'subscriptions' => [
				'vdn' => ['days' => [1, 5, 6]],
				'tv' => [],
				'fem' => [],
			],
		],[
			'name' => 'Mme BRABANT Monique',
			'address' => '4 allée du Banneret',
			'suburb' => '',
			'zipcode' => '59700',
			'city' => 'Marcq-en-Baroeul',
			'subscriptions' => [
				'vdn' => ['days' => [0, 5, 6]],
				'tv' => [],
				'fem' => [],
			],
		],[
			'name' => 'Mr CLERBOUT Abdon',
			'address' => '1 rue des Etendards',
			'suburb' => '',
			'zipcode' => '59700',
			'city' => 'Marcq-en-Baroeul',
			'subscriptions' => [
				'vdn' => [],
				'tv' => [],
				'fem' => [],
			],
		],[
			'name' => 'Mr NUMA Roland',
			'address' => '2 Chemin de la Fleur de Lys',
			'suburb' => '',
			'zipcode' => '59700',
			'city' => 'Marcq-en-Baroeul',
			'subscriptions' => [
				'vdn' => [],
				'tv' => [],
				'fem' => [],
			],
		],[
			'name' => 'Mr LLANES Yves',
			'address' => '10 Chemin de la Fleur de Lys',
			'suburb' => '',
			'zipcode' => '59700',
			'city' => 'Marcq-en-Baroeul',
			'subscriptions' => [
				'vdn' => [],
				'tv' => [],
				'fem' => [],
			],
		],[
			'name' => 'Mr BOUSSEMART Georges',
			'address' => '9 Chemin du Dauphin',
			'suburb' => '',
			'zipcode' => '59700',
			'city' => 'Marcq-en-Baroeul',
			'subscriptions' => [
				'vdn' => [],
				'tv' => [],
				'fem' => [],
			],
		],[
			'name' => 'Mme COUTURE VERMESSE',
			'address' => '4 Allée du Millenaires',
			'suburb' => '',
			'zipcode' => '59700',
			'city' => 'Marcq-en-Baroeul',
			'subscriptions' => [
				'vdn' => [],
				'tv' => [],
				'fem' => [],
			],
		],[
			'name' => 'Mme PRUVOST Claudine',
			'address' => '6 Chemin du Donjon',
			'suburb' => '',
			'zipcode' => '59700',
			'city' => 'Marcq-en-Baroeul',
			'subscriptions' => [
				'vdn' => [],
				'tv' => [],
				'fem' => [],
			],
		],[
			'name' => 'Mr BIERVOYE Michel',
			'address' => '15 rue La Fayette',
			'suburb' => '',
			'zipcode' => '59700',
			'city' => 'Marcq-en-Baroeul',
			'subscriptions' => [
				'vdn' => [],
			],
		],[
			'name' => 'Mme ARNOUX',
			'address' => '38 rue La Fayette',
			'suburb' => '',
			'zipcode' => '59700',
			'city' => 'Marcq-en-Baroeul',
			'subscriptions' => [
				'vdn' => ['days' => [0, 5, 6]],
				'tv' => [],
				'fem' => [],
			],
		],[
			'name' => 'Mr QUIEVRE Michel',
			'address' => '42 rue La Fayette',
			'suburb' => '',
			'zipcode' => '59700',
			'city' => 'Marcq-en-Baroeul',
			'subscriptions' => [
				'vdn' => [],
				'tv' => [],
				'fem' => [],
			],
		],[
			'name' => 'Mme MARECAUX Liliane',
			'address' => '58 rue La Fayette',
			'suburb' => '',
			'zipcode' => '59700',
			'city' => 'Marcq-en-Baroeul',
			'subscriptions' => [
				'vdn' => ['days' => [0, 5, 6]],
				'tv' => [],
				'fem' => [],
			],
		],[
			'name' => 'Mr ROSSEL Pierre',
			'address' => '92 rue La Fayette',
			'suburb' => '',
			'zipcode' => '59700',
			'city' => 'Marcq-en-Baroeul',
			'subscriptions' => [
				'vdn' => ['days' => [0, 5]],
				'tv' => [],
			],
		],[
			'name' => 'Mr BAERT',
			'address' => '100 rue La Fayette',
			'suburb' => '',
			'zipcode' => '59700',
			'city' => 'Marcq-en-Baroeul',
			'subscriptions' => [
				'vdn' => [],
				'tv' => [],
				'fem' => [],
			],
		],[
			'name' => 'Mme BAILLey Monique',
			'address' => '63 rue Raymond Derain',
			'suburb' => '',
			'zipcode' => '59700',
			'city' => 'Marcq-en-Baroeul',
			'subscriptions' => [
				'vdn' => [],
				'tv' => [],
				'fem' => [],
			],
		],[
			'name' => 'Mr CRUNELLE Raymond',
			'address' => '63 rue Raymond Derain',
			'suburb' => '',
			'zipcode' => '59700',
			'city' => 'Marcq-en-Baroeul',
			'subscriptions' => [
				'vdn' => [],
				'tv' => [],
				'fem' => [],
			],
		],[
			'name' => 'Mr DECROIX',
			'address' => '66 rue Raymond Derain',
			'suburb' => '',
			'zipcode' => '59700',
			'city' => 'Marcq-en-Baroeul',
			'subscriptions' => [
				'vdn' => [],
				'tv' => [],
				'fem' => [],
			],
		],[
			'name' => 'Mr THIRY Michel',
			'address' => '29 rue des Hautes Loges',
			'suburb' => '',
			'zipcode' => '59700',
			'city' => 'Marcq-en-Baroeul',
			'subscriptions' => [
				'vdn' => ['days' => [0, 2, 3, 4, 5, 6]],
				'tv' => [],
				'fem' => [],
			],
		],[
			'name' => 'Mr DEBRUYNE Jacques',
			'address' => '31 rue des Hautes Loges',
			'suburb' => '',
			'zipcode' => '59700',
			'city' => 'Marcq-en-Baroeul',
			'subscriptions' => [
				'vdn' => [],
				'tv' => [],
				'fem' => [],
				'vds' => []
			],
		],[
			'name' => 'Mr FRELIER Pierre',
			'address' => '7 rue des Enseignes',
			'suburb' => '',
			'zipcode' => '59700',
			'city' => 'Marcq-en-Baroeul',
			'subscriptions' => [
				'vdn' => [],
				'tv' => [],
				'fem' => [],
			],
		],[
			'name' => 'Mr DUBOIS Stéphane',
			'address' => '19 rue des Enseignes',
			'suburb' => '',
			'zipcode' => '59700',
			'city' => 'Marcq-en-Baroeul',
			'subscriptions' => [
				'vdn' => [],
				'tv' => [],
				'fem' => [],
			],
		],[
			'name' => 'Mr LEMAIRE Christophe',
			'address' => '2 Allée des Lices',
			'suburb' => '',
			'zipcode' => '59700',
			'city' => 'Marcq-en-Baroeul',
			'subscriptions' => [
				'vdn' => ['days' => [0]],
			],
		],[
			'name' => 'Mr MASQUELIER Augustin',
			'address' => '13 Allée des Lices',
			'suburb' => '',
			'zipcode' => '59700',
			'city' => 'Marcq-en-Baroeul',
			'subscriptions' => [
				'vdn' => [],
				'tv' => [],
				'fem' => [],
			],
		],[
			'name' => 'Mr MONTIGNY',
			'address' => '4 Allée des Archers',
			'suburb' => '',
			'zipcode' => '59700',
			'city' => 'Marcq-en-Baroeul',
			'subscriptions' => [
				'vdn' => [],
				'tv' => [],
				'fem' => [],
			],
		],[
			'name' => 'Mr ROLAND Jean',
			'address' => '1 rue du Grand Pavois',
			'suburb' => '',
			'zipcode' => '59700',
			'city' => 'Marcq-en-Baroeul',
			'subscriptions' => [
				'vdn' => [],
				'tv' => [],
				'fem' => [],
			],
		],
	];
}
