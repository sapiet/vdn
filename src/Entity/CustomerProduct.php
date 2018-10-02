<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CustomerProduct
 *
 * @ORM\Table(name="customer_product")
 * @ORM\Entity(repositoryClass="App\Repository\CustomerProductRepository")
 */
class CustomerProduct
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Customer", inversedBy="customerProducts")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     */
    private $customer;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="customerProducts")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;

    /**
     * @var array
     *
     * @ORM\Column(name="days", type="simple_array")
     */
    private $days;

    /**
     * @return mixed
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param mixed $customer
     *
     * @return self
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param mixed $product
     *
     * @return self
     */
    public function setProduct($product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return array
     */
    public function getDays()
    {
        return $this->days;
    }

    /**
     * @param array $days
     *
     * @return self
     */
    public function setDays(array $days)
    {
        $this->days = $days;

        return $this;
    }
}
