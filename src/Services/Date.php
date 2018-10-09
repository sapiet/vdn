<?php

namespace App\Services;

use DateTime;

class Date
{
    const MONTHS = [
        'janvier',
        'février',
        'mars',
        'avril',
        'mai',
        'juin',
        'juillet',
        'août',
        'septembre',
        'octobre',
        'novembre',
        'décembre',
    ];

    const DAYS = [
        'dimanche',
        'lundi',
        'mardi',
        'mercredi',
        'jeudi',
        'vendredi',
        'samedi',
    ];

    public static function getDaysCountInMonth(int $month, int $year)
    {
        $daysCount = [];
        $date = new DateTime($year.'-'.$month.'-01');

        while ((int) $date->format('m') === $month) {
            $dayNumber = $date->format('w');

            if (!array_key_exists($dayNumber, $daysCount)) {
                $daysCount[$dayNumber] = 0;
            }

            $daysCount[$dayNumber]++;

            $date->modify('+1 day');
        }

        ksort($daysCount);

        return $daysCount;
    }
}
