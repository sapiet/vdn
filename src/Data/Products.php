<?php

namespace App\Data;

class Products
{
    const LIST = [
        'vdn' => [
            'designation' => 'Journal La Voix du Nord',
            'days' => [0, 1, 2, 3, 4, 5, 6],
            'price' => 1.25,
        ],
        'tv' => [
            'designation' => 'Supplément TV',
            'days' => [5],
            'price' => 0.20,
        ],
        'fem' => [
            'designation' => 'Supplément Femina',
            'days' => [6],
            'price' => 0.20,
        ],
        'vds' => [
            'designation' => 'Supplément Voix des Sports',
            'days' => [1],
            'price' => 0.35,
        ]
    ];
}
