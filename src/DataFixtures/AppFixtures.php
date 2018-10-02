<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Company;
use App\Entity\DeliveryMan;
use App\Entity\Product;
use App\Entity\Customer;
use App\Entity\Subscription;
use App\Data\Company as CompanyData;
use App\Data\DeliveryMan as DeliveryManData;
use App\Data\Products;
use App\Data\Customer as CustomerData;

class AppFixtures extends Fixture
{
    private $deliveryMan;
    private $products = [];

    public function load(ObjectManager $manager)
    {
        $this->loadCompany($manager);
        $this->loadDeliveryMan($manager);
        $this->loadProducts($manager);
        $this->loadCustomers($manager);
    }

    public function loadCompany(ObjectManager $manager)
    {
        $company = (new Company())
            ->setName(CompanyData::DATA['name'])
            ->setAddress(CompanyData::DATA['address'])
            ->setSuburb(CompanyData::DATA['suburb'])
            ->setZipcode(CompanyData::DATA['zipcode'])
            ->setCity(CompanyData::DATA['city'])
        ;
        $manager->persist($company);
        $manager->flush();
    }

    public function loadDeliveryMan(ObjectManager $manager)
    {
        $deliveryMan = (new DeliveryMan())
            ->setName(DeliveryManData::DATA['name'])
            ->setAddress(DeliveryManData::DATA['address'])
            ->setSuburb(DeliveryManData::DATA['suburb'])
            ->setZipcode(DeliveryManData::DATA['zipcode'])
            ->setCity(DeliveryManData::DATA['city'])
            ->setPhone(DeliveryManData::DATA['phone'])
        ;
        $manager->persist($deliveryMan);
        $manager->flush();

        $this->deliveryMan = $deliveryMan;
    }

    public function loadProducts(ObjectManager $manager)
    {
        foreach (Products::LIST as $productCode => $productData) {
            $product = (new Product())
                ->setCode($productCode)
                ->setDesignation($productData['designation'])
                ->setDays($productData['days'])
                ->setPrice($productData['price'])
            ;

            $manager->persist($product);
            $manager->flush();

            $this->products[$productCode] = $product;
        }
    }

    public function loadCustomers(ObjectManager $manager)
    {
        foreach (CustomerData::LIST as $customerData) {
            $customer = (new Customer())
                ->setName($customerData['name'])
                ->setAddress($customerData['address'])
                ->setSuburb($customerData['suburb'])
                ->setZipcode($customerData['zipcode'])
                ->setCity($customerData['city'])
                ->setDeliveryMan($this->deliveryMan)
            ;

            $manager->persist($customer);
            $manager->flush();

            foreach ($customerData['subscriptions'] as $code => $subscription) {
                $subscriptionEntity = (new Subscription())
                    ->setCustomer($customer)
                    ->setProduct($this->products[$code])
                    ->setDays(array_key_exists('days', $subscription) ? $subscription['days'] : [])
                ;

                $manager->persist($subscriptionEntity);
                $manager->flush();
            }

        }
    }
}
