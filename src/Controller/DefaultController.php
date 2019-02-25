<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Services\InvoiceService;
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
    public function index(Request $request, InvoiceService $invoiceService)
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

            $invoiceService->process($selectedDeliveryMan, $selectedDate, $selectedCustomers);
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

    private function getRepository($name)
    {
        return $this->getDoctrine()->getManager()->getRepository('App:'.$name);
    }
}
