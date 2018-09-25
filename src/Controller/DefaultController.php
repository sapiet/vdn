<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Spipu\Html2Pdf\Html2Pdf;
use App\Data\Customer;
use App\Data\Company;

class DefaultController extends AbstractController
{
	public function index()
	{
		foreach (Customer::LIST as $customer) {
			$company = Company::DATA;
			$products = [
				[
					'designation' => 'Journal La Voix du Nord',
					'quantity' => 1,
					'price' => '1.25€',
				],[
					'designation' => 'Journal La Voix du Nord',
					'quantity' => 1,
					'price' => '1.25€',
				],[
					'designation' => 'Journal La Voix du Nord',
					'quantity' => 1,
					'price' => '1.25€',
				],[
					'designation' => 'Journal La Voix du Nord',
					'quantity' => 1,
					'price' => '1.25€',
				],
			];

			$templateVars = compact('company', 'customer', 'products');

			$html2pdf = new Html2Pdf();
			$html2pdf->writeHTML($this->renderView('invoice.html.twig', $templateVars));
			$html2pdf->output();
			//$html2pdf->output('/Users/xavierquievre/Sites/vdn/facture.pdf', 'F');
		}
	}
}
