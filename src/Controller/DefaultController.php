<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Spipu\Html2Pdf\Html2Pdf;
use App\Entity\DeliveryMan;
use App\Entity\Subscription;
use App\Form\SubscriptionType;
use App\Services\Date;
use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use DateTime;

class DefaultController extends AbstractController
{
    const CURRENCY = '€';

    public function index(Request $request)
    {
        $selectedDeliveryMan = null;
        if ($request->query->has('deliveryManId')) {
            $deliveryManId = $request->query->get('deliveryManId');
            $selectedDeliveryMan = $this->getRepository('DeliveryMan')->find($deliveryManId);
        }

        if ($request->query->has('month') && $request->query->has('year') && $selectedDeliveryMan) {
            $selectedMonth = $request->query->get('month');
            $selectedYear = $request->query->get('year');
            $selectedDate = new DateTimeImmutable($selectedYear.'-'.$selectedMonth.'-01');
            $selectedCustomers = array_keys($request->query->get('selectedCustomers', []));
            $this->process($selectedDate, $selectedDeliveryMan, $selectedCustomers);
        }

        $deliveryMen = $this->getRepository('DeliveryMan')->findAll();

        $currentDate = new DateTime();
        $currentYear = $currentDate->format('Y');
        $currentMonth = $currentDate->format('n') - 1;
        $months = Date::MONTHS;
        $years = range(2018, 2030);
        $formatedDays = Date::DAYS;
        $templateVars = compact('months', 'years', 'currentYear', 'currentMonth', 'deliveryMen', 'selectedDeliveryMan', 'formatedDays');

        return $this->render('index.html.twig', $templateVars);

    }

    public function process(DateTimeInterface $date, DeliveryMan $deliveryMan, array $selectedCustomers)
    {
        $month = (int) $date->format('m');
        $year = (int) $date->format('Y');

        $html = '';
        $daysCount = Date::getDaysCountInMonth($month, $year);

        $manager = $this->getDoctrine()->getManager();
        $company = $deliveryMan->getCompany();

        $products = [];
        foreach ($manager->getRepository('App:Product')->findAll() as $product) {
            $products[$product->getCode()] = $product;
        }

        $deliveryMan = $manager->getRepository('App:DeliveryMan')->findAll()[0];
        $limitPaymentDate = $date->modify('+1 month');
        $formatedLimitPaymentDate = '10 '.$this->formatDate($limitPaymentDate);

        foreach ($deliveryMan->getCustomers() as $customer) {
            if (empty($selectedCustomers) || in_array($customer->getId(), $selectedCustomers)) {
                $customerProducts = [];

                foreach ($customer->getSubscriptions() as $subscription) {
                    $product = $subscription->getProduct();
                    $quantity = 0;

                    $countByDays = [];

                    foreach ($subscription->getDays() ? $subscription->getDays() : $product->getDays() as $day) {
                        $countByDays[Date::DAYS[$day]] = $daysCount[$day];
                    }

                    $quantity = array_sum($countByDays);

                    $customerProducts[] = [
                        'designation' => $product->getDesignation(),
                        'quantity' => $quantity,
                        'formatedPrice' => $this->formatPrice($product->getPrice()),
                        'totalPrice' => round($quantity * $product->getPrice(), 2),
                        'totalFormatedPrice' => $this->formatPrice($quantity * $product->getPrice()),
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
        }

        $html2pdf = new Html2Pdf();
        $html2pdf->writeHTML($html);
        $html2pdf->output();
        //$html2pdf->output('/Users/xavierquievre/Sites/vdn/'.$customer['lastname'].' '.$customer['firstname'].'.pdf', 'F');
    }

    public function customerSubscriptions(Request $request, $customerId)
    {
        $customer = $this->getRepository('Customer')->find($customerId);
        $formatedDays = Date::DAYS;

        $form = $this->createForm(SubscriptionType::class, new Subscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $subscription = $form->getData();
            $subscription->setCustomer($customer);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($subscription);
            $entityManager->flush();

            $routeParameters = compact('customerId');

            return $this->redirectToRoute('customer_subscription', $routeParameters);
        }

        $form = $form->createView();

        $templateVars = compact('customer', 'formatedDays', 'form');

        return $this->render('customer-subscriptions.html.twig', $templateVars);
    }

    public function deleteCustomerSubscription(Request $request, $subscriptionId)
    {
        $subscription = $this->getRepository('Subscription')->find($subscriptionId);
        $customerId = $subscription->getCustomer()->getId();

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($subscription);
        $entityManager->flush();

        $routeParameters = compact('customerId');

        return $this->redirectToRoute('customer_subscription', $routeParameters);
    }

    private function getProducts(): array
    {
        $products = [];

        foreach ($this->getRepository('Product')->findAll() as $product) {
            $products[$product->getCode()] = $product;
        }

        return $products;
    }

    private function getRepository($name)
    {
        return $this->getDoctrine()->getManager()->getRepository('App:'.$name);
    }

    public function prefixDate(DateTimeInterface $date): string
    {
        $date = $this->formatDate($date);
        return (in_array(strtolower($date[0]), ['a', 'e', 'i', 'o', 'u', 'y']) ? 'd\'' : 'de ').$date;
    }

    public function formatDate(DateTimeInterface $date): string
    {
        return Date::MONTHS[(int) $date->format('m') - 1].' '.(int) $date->format('Y');
    }

    public function formatPrice(float $price): string
    {
        return number_format($price, 2, ',', ' ').self::CURRENCY;
    }

    // public function processOld(DateTimeInterface $date)
    // {
    //     $month = (int) $date->format('m');
    //     $year = (int) $date->format('Y');

    //     $html = '';
    //     $daysCount = Date::getDaysCountInMonth($month, $year);
    //     $company = Company::DATA;
    //     $products = Products::LIST;
    //     $deliveryMan = DeliveryMan::DATA;
    //     $limitPaymentDate = $date->modify('+1 month');
    //     $formatedLimitPaymentDate = '10 '.$this->formatDate($limitPaymentDate);

    //     foreach (Customer::LIST as $customer) {
    //         $customerProducts = [];

    //         if (!array_key_exists('subscriptions', $customer)) {
    //             throw new Exception('Undefined subscriptions for '.$customer['name']);
    //         }

    //         foreach ($customer['subscriptions'] as $code => $parameters) {
    //             $product = $products[$code];
    //             $quantity = 0;

    //             $countByDays = [];

    //             foreach (array_key_exists('days', $parameters) ? $parameters['days'] : $product['days'] as $day) {
    //                 $countByDays[Date::DAYS[$day]] = $daysCount[$day];
    //             }

    //             $quantity = array_sum($countByDays);

    //             $customerProducts[] = [
    //                 'designation' => $product['designation'],
    //                 'quantity' => $quantity,
    //                 'formatedPrice' => $this->formatPrice($product['price']),
    //                 'totalPrice' => round($quantity * $product['price'], 2),
    //                 'totalFormatedPrice' => $this->formatPrice($quantity * $product['price']),
    //                 'countByDays' => $countByDays
    //             ];
    //         }

    //         if (!empty($customerProducts)) {
    //             $total = number_format(array_reduce($customerProducts, function($sum, $item) {
    //                 return $sum += $item['totalPrice'];
    //             }, 0), 2, ',', ' ').'€';

    //             $formatedDate = $this->prefixDate($date);

    //             $templateVars = compact('company', 'customer', 'customerProducts', 'total', 'formatedDate', 'deliveryMan', 'formatedLimitPaymentDate');
    //             $html .= $this->renderView('invoice.html.twig', $templateVars);
    //         }
    //     }

    //     $html2pdf = new Html2Pdf();
    //     $html2pdf->writeHTML($html);
    //     $html2pdf->output();
    //     //$html2pdf->output('/Users/xavierquievre/Sites/vdn/'.$customer['lastname'].' '.$customer['firstname'].'.pdf', 'F');
    // }
}
