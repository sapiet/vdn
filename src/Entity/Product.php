<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=255)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="designation", type="string", length=255)
     */
    private $designation;

    /**
     * @var array
     *
     * @ORM\Column(name="days", type="simple_array")
     */
    private $days;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity="Subscription", mappedBy="product")
     */
    private $subscriptions;

    public function __construct()
    {
        $this->subscriptions = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     *
     * @return self
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return string
     */
    public function getDesignation()
    {
        return $this->designation;
    }

    /**
     * @param string $designation
     *
     * @return self
     */
    public function setDesignation($designation)
    {
        $this->designation = $designation;

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

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     *
     * @return self
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubscriptions()
    {
        return $this->subscriptions;
    }

    /**
     * @param mixed $subscriptions
     *
     * @return self
     */
    public function setSubscriptions($subscriptions)
    {
        $this->subscriptions = $subscriptions;

        return $this;
    }
}

