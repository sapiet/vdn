<?php

namespace App\Services;

use DateTime;
use DateInterval;
use DateTimeImmutable;
use DateTimeInterface;
use Twig\Environment;
use Spipu\Html2Pdf\Html2Pdf;
use App\Entity\Customer;
use App\Entity\DeliveryMan;
use App\Entity\Subscription;
use App\Repository\DeliveryManRepository;
use App\Repository\ProductRepository;
use App\Services\Date;

class InvoiceService
{
    const CURRENCY = '€';

    private $templating;
    private $deliveryManRepository;
	private $productRepository;
	private $html;

	public function __construct(
        Environment $templating,
        DeliveryManRepository $deliveryManRepository,
		ProductRepository $productRepository
	) {
        $this->templating = $templating;
        $this->deliveryManRepository = $deliveryManRepository;
		$this->productRepository = $productRepository;
	}

    private function formatDate(DateTimeInterface $date): string
    {
        return Date::MONTHS[(int) $date->format('m') - 1].' '.(int) $date->format('Y');
    }

    private function prefixDate(DateTimeInterface $date): string
    {
        $date = $this->formatDate($date);
        return (in_array(strtolower($date[0]), ['a', 'e', 'i', 'o', 'u', 'y']) ? 'd\'' : 'de ').$date;
    }

    private function formatPrice(float $price): string
    {
        return number_format($price, 2, ',', ' ').self::CURRENCY;
    }

    private function getCountByDays(Subscription $subscription, DateTimeInterface $date): array
    {
        $daysCount = Date::getDaysCountInMonth($date->format('m'), $date->format('Y'));

        $countByDays = [];

        foreach ($subscription->getDays() ? $subscription->getDays() : $subscription->getProduct()->getDays() as $day) {
            $countByDays[Date::DAYS[$day]] = $daysCount[$day];
        }

        return $countByDays;
    }

    public function calculPurchases(DeliveryMan $deliveryMan, DateTimeInterface $date, array $selectedCustomers)
    {
        $purchases = [];

        foreach ($deliveryMan->getCustomers() as $customer) {
            if (empty($selectedCustomers) || in_array($customer->getId(), $selectedCustomers)) {
                $purchases[] = $this->calculPurchase($deliveryMan, $customer, $date);
            }
        }

        return $purchases;
    }

    public function calculPurchase(DeliveryMan $deliveryMan, Customer $customer, DateTimeInterface $date)
    {
        $purchase = [
            'formatedLimitPaymentDate' => '10 '.$this->formatDate($date->modify('+1 month')),
            'formatedDate' => $this->prefixDate($date),
            'customer' => $customer,
            'total' => 0,
            'products' => [],
        ];

        foreach ($customer->getSubscriptions() as $subscription) {
            $product = $subscription->getProduct();
            $quantity = 0;

            $countByDays = $this->getCountByDays($subscription, $date);

            $quantity = array_sum($countByDays);

            $totalPrice = round($quantity * $product->getPrice(), 2);

            $purchase['products'][] = [
                'designation' => $product->getDesignation(),
                'quantity' => $quantity,
                'formatedPrice' => $this->formatPrice($product->getPrice()),
                'totalPrice' => $totalPrice,
                'totalFormatedPrice' => $this->formatPrice($quantity * $product->getPrice()),
                'countByDays' => $countByDays
            ];

            $purchase['total'] += $totalPrice;
        }

        $purchase['total'] = number_format($purchase['total'], 2, ',', ' ').self::CURRENCY;
        $templateVars = compact('deliveryMan', 'purchase');
        $purchase['invoice'] = $this->templating->render('invoice.html.twig', $templateVars);

        return $purchase;
    }

    public function processCustomers(array $purchases)
    {
        foreach ($purchases as $purchase) {
            $this->html .= $purchase['invoice'];
        }
    }

    public function processSummary(DateTimeInterface $date, array $purchases)
    {
        $formatedDate = $this->prefixDate($date);
        $templateVars = compact('formatedDate', 'purchases');
        $this->html .= $this->templating->render('summary.html.twig', $templateVars);
    }

    public function process(DeliveryMan $deliveryMan, DateTimeInterface $date, array $selectedCustomers = [], array $output = [])
    {
		$month = (int) $date->format('m');
        $year = (int) $date->format('Y');

		$this->html = '';

        $purchases = $this->calculPurchases($deliveryMan, $date, $selectedCustomers);

        $this->processCustomers($purchases);
        $this->processSummary($date, $purchases);

        $html2pdf = new Html2Pdf();
        $html2pdf->writeHTML($this->html);

        if ($output) {
            return $html2pdf->output($output['name'], $output['mode']);
        } else {
            return $html2pdf->output();
        }
	}

    public function export(int $deliveryManId, DateTimeInterface $date)
    {
        $deliveryMan = $this->deliveryManRepository->find($deliveryManId);
        $name = 'factures-'.$date->format('m-Y').'.pdf';
        dump('Generating '.$name);
        $pdfContent = $this->process($deliveryMan, $date, [], ['name' => '', 'mode' => 'S']);
        file_put_contents($name, $pdfContent);
    }
}
