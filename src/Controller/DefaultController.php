<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Spipu\Html2Pdf\Html2Pdf;
use App\Data\Customer;
use App\Data\Company;
use App\Data\Products;
use App\Services\Date;

class DefaultController extends AbstractController
{
	public function index()
	{
		$daysCount = Date::getDaysCountInMonth(2018, 9);
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

				if ($quantity > 0) {
					$customerProducts[] = [
						'designation' => $product['designation'],
						'quantity' => $quantity,
						'price' => round($quantity * $product['price']).'€',
					];
				}
			}

			$total = round(array_reduce($customerProducts, function($sum, $item) {
				return $sum += $item['price'];
			}, 0), 2).'€';

			$templateVars = compact('company', 'customer', 'customerProducts', 'total');

			$html2pdf = new Html2Pdf();
			$html2pdf->writeHTML($this->renderView('invoice.html.twig', $templateVars));
			$html2pdf->output();
			//$html2pdf->output('/Users/xavierquievre/Sites/vdn/facture.pdf', 'F');
		}
	}
}
