<?php

namespace MyShop\DefaultBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * CustomerOrder
 *
 * @ORM\Table(name="customer_order")
 * @ORM\Entity(repositoryClass="MyShop\DefaultBundle\Repository\CustomerOrderRepository")
 */
class CustomerOrder
{
    const STATUS_OPEN = 1;
    const STATUS_DONE = 2;
    const STATUS_REJECT = 3;
    const STATUS_RESOLVE = 4;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreatedAt", type="datetime")
     */
    private $dateCreatedAt;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_number", type="string", length=255, nullable=true)
     */
    private $phoneNumber;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="MyShop\DefaultBundle\Entity\OrderProduct", mappedBy="order", cascade={"all"})
    */
    private $products;

    /**
     * @var Customer
     *
     * @ORM\ManyToOne(targetEntity="MyShop\DefaultBundle\Entity\Customer", inversedBy="orders")
     * @ORM\JoinColumn(name="id_customer", referencedColumnName="id")
    */
    private $customer;


    public function __construct()
    {
        $this->setDateCreatedAt(new \DateTime("now"));
        $this->setStatus(self::STATUS_OPEN);
        $this->products = new ArrayCollection();
    }

    public function getTotalPrice()
    {
        $total = 0;
        /** @var OrderProduct $product */
        foreach ($this->products as $product) {
            $total = $total + ( $product->getPrice() * $product->getCount());
        }

        return $total;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dateCreatedAt
     *
     * @param \DateTime $dateCreatedAt
     *
     * @return CustomerOrder
     */
    public function setDateCreatedAt($dateCreatedAt)
    {
        $this->dateCreatedAt = $dateCreatedAt;

        return $this;
    }

    /**
     * Get dateCreatedAt
     *
     * @return \DateTime
     */
    public function getDateCreatedAt()
    {
        return $this->dateCreatedAt;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return CustomerOrder
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Add product
     *
     * @param \MyShop\DefaultBundle\Entity\OrderProduct $product
     *
     * @return CustomerOrder
     */
    public function addProduct(\MyShop\DefaultBundle\Entity\OrderProduct $product)
    {
        $product->setOrder($this);
        $this->products[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \MyShop\DefaultBundle\Entity\OrderProduct $product
     */
    public function removeProduct(\MyShop\DefaultBundle\Entity\OrderProduct $product)
    {
        $this->products->removeElement($product);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Set customer
     *
     * @param \MyShop\DefaultBundle\Entity\Customer $customer
     *
     * @return CustomerOrder
     */
    public function setCustomer(\MyShop\DefaultBundle\Entity\Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \MyShop\DefaultBundle\Entity\Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }
}
