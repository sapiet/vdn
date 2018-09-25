<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Spipu\Html2Pdf\Html2Pdf;
use App\Data\Customer;
use App\Data\Company;
use App\Data\Products;
use App\Services\Date;
use DateTime;

class DefaultController extends AbstractController
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

	const CURRENCY = '€';

	public function index()
	{
		$date = new DateTime();
		$month = (int) $date->format('m');
		$year = (int) $date->format('Y');

		$html = '';
		$daysCount = Date::getDaysCountInMonth($month, $year);
		$company = Company::DATA;
		$products = Products::LIST;

		foreach (Customer::LIST as $customer) {
			$customerProducts = [];

			foreach ($customer['subscriptions'] as $subscription) {
				$product = $products[$subscription];
				$quantity = 0;

				foreach ($product['days'] as $day) {
					$quantity += $daysCount[$day];
				}

				$customerProducts[] = [
					'designation' => $product['designation'],
					'quantity' => $quantity,
					'formatedPrice' => $this->formatPrice($product['price']),
					'totalPrice' => round($quantity * $product['price'], 2),
					'totalFormatedPrice' => $this->formatPrice($quantity * $product['price']),
				];
			}

			if (!empty($customerProducts)) {
				$total = number_format(array_reduce($customerProducts, function($sum, $item) {
					return $sum += $item['totalPrice'];
				}, 0), 2, ',', ' ').'€';

				$date = self::MONTHS[$month - 1].' '.$year;
				$date = (in_array(strtolower($date[0]), ['a', 'e', 'i', 'o', 'u', 'y']) ? 'd\'' : 'de ').$date;

				$templateVars = compact('company', 'customer', 'customerProducts', 'total', 'date');
				$html .= $this->renderView('invoice.html.twig', $templateVars);
			}
		}

		$html2pdf = new Html2Pdf();
		$html2pdf->writeHTML($html);
		$html2pdf->output();
		//$html2pdf->output('/Users/xavierquievre/Sites/vdn/'.$customer['lastname'].' '.$customer['firstname'].'.pdf', 'F');
	}

	public function formatPrice($price)
	{
		return number_format($price, 2, ',', ' ').self::CURRENCY;
	}
}
