<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Spipu\Html2Pdf\Html2Pdf;
use App\Data\Customer;
use App\Data\Company;
use App\Data\Products;
use App\Data\DeliveryMan;
use App\Services\Date;
use DateTimeImmutable;
use DateTimeInterface;
use Exception;

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

	const DAYS = [
		'dimanche',
		'lundi',
		'mardi',
		'mercredi',
		'jeudi',
		'vendredi',
		'samedi',
	];

	const CURRENCY = '€';

	public function index(Request $request)
	{
		if ($request->query->has('month') && $request->query->has('year')) {
			$selectedMonth = $request->query->get('month');
			$selectedYear = $request->query->get('year');
			$selectedDate = new DateTimeImmutable($selectedYear.'-'.$selectedMonth.'-01');
			$this->process($selectedDate);
		}

		$currentDate = new DateTime();
		$currentYear = $currentDate->format('Y');
		$currentMonth = $currentDate->format('n') - 1;
		$months = self::MONTHS;
		$years = range(2018, 2030);
		$templateVars = compact('months', 'years', 'currentYear', 'currentMonth');

		return $this->render('index.html.twig', $templateVars);

	}

	public function process(DateTimeInterface $date)
	{
		$month = (int) $date->format('m');
		$year = (int) $date->format('Y');

		$html = '';
		$daysCount = Date::getDaysCountInMonth($month, $year);
		$company = Company::DATA;
		$products = Products::LIST;
		$deliveryMan = DeliveryMan::DATA;
		$limitPaymentDate = $date->modify('+1 month');
		$formatedLimitPaymentDate = '10 '.$this->formatDate($limitPaymentDate);

		foreach (Customer::LIST as $customer) {
			$customerProducts = [];

			if (!array_key_exists('subscriptions', $customer)) {
				throw new Exception('Undefined subscriptions for '.$customer['name']);
			}

			foreach ($customer['subscriptions'] as $code => $parameters) {
				$product = $products[$code];
				$quantity = 0;

				$countByDays = [];

				foreach (array_key_exists('days', $parameters) ? $parameters['days'] : $product['days'] as $day) {
					$countByDays[self::DAYS[$day]] = $daysCount[$day];
				}

				$quantity = array_sum($countByDays);

				$customerProducts[] = [
					'designation' => $product['designation'],
					'quantity' => $quantity,
					'formatedPrice' => $this->formatPrice($product['price']),
					'totalPrice' => round($quantity * $product['price'], 2),
					'totalFormatedPrice' => $this->formatPrice($quantity * $product['price']),
					'countByDays' => $countByDays
				];
			}

			if (!empty($customerProducts)) {
				$total = number_format(array_reduce($customerProducts, function($sum, $item) {
					return $sum += $item['totalPrice'];
				}, 0), 2, ',', ' ').'€';

				$formatedDate = $this->prefixDate($date);

				$templateVars = compact('company', 'customer', 'customerProducts', 'total', 'formatedDate', 'deliveryMan', 'formatedLimitPaymentDate');
				$html .= $this->renderView('invoice.html.twig', $templateVars);
			}
		}

		$html2pdf = new Html2Pdf();
		$html2pdf->writeHTML($html);
		$html2pdf->output();
		//$html2pdf->output('/Users/xavierquievre/Sites/vdn/'.$customer['lastname'].' '.$customer['firstname'].'.pdf', 'F');
	}

	public function prefixDate(DateTimeInterface $date): string
	{
		$date = $this->formatDate($date);
		return (in_array(strtolower($date[0]), ['a', 'e', 'i', 'o', 'u', 'y']) ? 'd\'' : 'de ').$date;
	}

	public function formatDate(DateTimeInterface $date): string
	{
		return self::MONTHS[(int) $date->format('m') - 1].' '.(int) $date->format('Y');
	}

	public function formatPrice(float $price): string
	{
		return number_format($price, 2, ',', ' ').self::CURRENCY;
	}
}
