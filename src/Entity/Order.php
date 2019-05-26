<?php 

// src/Entity/Order.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 * @ORM\Table(name="orders")
 */
class Order {
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
    * @Assert\NotBlank()
    * @ORM\Column(type="integer")
    */
    private $userId;
    /**
    * @Assert\NotBlank()
    * @ORM\Column(type="float", scale=2)
    */
    private $totalAmount;
    /**
    * @ORM\Column(type="float", scale=2)
    */
    private $discount=0;
    /**
    * @ORM\Column(type="integer", nullable=true)
    */
    private $totalItems;
    /**
    * @ORM\Column(type="string", length=255, nullable=true)
    */
    private $orderNumber;
    /**
    * @ORM\Column(type="string", length=15, options={"comment":"Pending, Confirmed, Delivered, Canceled"})
    */
    private $status = 'Pending';
    /**
    * @ORM\Column(type="string", length=30, options={"comment":"Card, PayPal, Cash on delivery"})
    */
    private $paymentMethod = 'Card';
    /**
    * @ORM\Column(type="string", length=20, options={"comment":"DHL, FedEx"})
    */
    private $shippingMethod = 'DHL';
    /**
    * @ORM\Column(type="float", scale=2, nullable=true)
    */
    private $shippingCost;
    /**
     * @ORM\Column(type="text", length=150, nullable=true)
    */
    private $fullName;
    /**
     * @ORM\Column(type="text", length=150, nullable=true)
    */
    private $email;
    /**
     * @ORM\Column(type="text", length=150, nullable=true)
    */
    private $contactNumber;
    /**
     * @ORM\Column(type="text", length=150, nullable=true)
    */
    private $postalCode;
    /**
     * @ORM\Column(type="text", length=150, nullable=true)
    */
    private $shippingAddress;
    /**
     * @ORM\Column(type="text", length=150, nullable=true)
    */
    private $city;
    /**
     * @ORM\Column(type="text", length=150, nullable=true)
    */
    private $country;
    /**
     * @ORM\Column(type="text", length=150, nullable=true)
    */
    private $customerNotes;
    /**
     * @ORM\Column(type="text", length=150, nullable=true)
    */
    private $adminNotes;
    /**
     * @ORM\Column(type="text", length=150, nullable=true)
    */
    private $ipAddress;
    /**
    * @ORM\Column(type="text", length=150, options={"comment":"Some payment gateway return transaction id we may save here"}, nullable=true)
    */
    private $transactionId;
    /**
    * @ORM\Column(type="datetime")
    */
    private $createdAt;
    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;


    //Getters and Setters

    /**
    * @return mixed
    */
    public function getId()
    { 
        return $this->id; 
    }
    /**
    * @param mixed $id
    */
    public function setId($id)
    { 
        $this->id = $id; 
    }

    /**
    * @return mixed
    */
    public function getUserId()
    { 
        return $this->userId; 
    }
    /**
    * @param mixed $id
    */
    public function setUserId($userId)
    { 
        $this->userId = $userId; 
    }
    /**
    * @return mixed
    */
    public function getTotalAmount()
    { 
        return $this->totalAmount; 
    }
    /**
    * @param mixed $id
    */
    public function setTotalAmount($totalAmount)
    { 
        $this->totalAmount = $totalAmount; 
    }
    /**
    * @return mixed
    */
    public function getDiscount()
    { 
        return $this->discount; 
    }
    /**
    * @param mixed $id
    */
    public function setDiscount($discount)
    { 
        $this->discount = $discount; 
    }
    /**
    * @return mixed
    */
    public function getTotalItems()
    { 
        return $this->totalItems; 
    }
    /**
    * @param mixed $id
    */
    public function setTotalItems($totalItems)
    { 
        $this->totalItems = $totalItems; 
    }
    /**
    * @return mixed
    */
    public function getOrderNumber()
    { 
        return $this->orderNumber; 
    }
    /**
    * @param mixed $id
    */
    public function setOrderNumber($orderNumber)
    { 
        $this->orderNumber = $orderNumber; 
    }
    /**
    * @return mixed
    */
    public function getStatus()
    { 
        return $this->status; 
    }
    /**
    * @param mixed $id
    */
    public function setStatus($status)
    { 
        $this->status = $status; 
    }
    /**
    * @return mixed
    */
    public function getPaymentMethod()
    { 
        return $this->paymentMethod; 
    }
    /**
    * @param mixed $id
    */
    public function setPaymentMethod($paymentMethod)
    { 
        $this->paymentMethod = $paymentMethod; 
    }
    /**
    * @return mixed
    */
    public function getShippingMethod()
    { 
        return $this->shippingMethod; 
    }
    /**
    * @param mixed $id
    */
    public function setShippingMethod($shippingMethod)
    { 
        $this->shippingMethod = $shippingMethod; 
    }
    /**
    * @return mixed
    */
    public function getShippingCost()
    { 
        return $this->shippingCost; 
    }
    /**
    * @param mixed $id
    */
    public function setShippingCost($shippingCost)
    { 
        $this->shippingCost = $shippingCost; 
    }
    /**
    * @return mixed
    */
    public function getFullName()
    { 
        return $this->fullName; 
    }
    /**
    * @param mixed $id
    */
    public function setFullName($fullName)
    { 
        $this->fullName = $fullName; 
    }
    /**
    * @return mixed
    */
    public function getEmail()
    { 
        return $this->email; 
    }
    /**
    * @param mixed $id
    */
    public function setEmail($email)
    { 
        $this->email = $email; 
    }
    /**
    * @return mixed
    */
    public function getContactNumber()
    { 
        return $this->contactNumber; 
    }
    /**
    * @param mixed $id
    */
    public function setContactNumber($contactNumber)
    { 
        $this->contactNumber = $contactNumber; 
    }
    /**
    * @return mixed
    */
    public function getPostalCode()
    { 
        return $this->postalCode; 
    }
    /**
    * @param mixed $id
    */
    public function setPostalCode($postalCode)
    { 
        $this->postalCode = $postalCode; 
    }
    /**
    * @return mixed
    */
    public function getShippingAddress()
    { 
        return $this->shippingAddress; 
    }
    /**
    * @param mixed $id
    */
    public function setShippingAddress($shippingAddress)
    { 
        $this->shippingAddress = $shippingAddress; 
    }
    /**
    * @return mixed
    */
    public function getCity()
    { 
        return $this->city; 
    }
    /**
    * @param mixed $id
    */
    public function setCity($city)
    { 
        $this->city = $city; 
    }
    /**
    * @return mixed
    */
    public function getCountry()
    { 
        return $this->country; 
    }
    /**
    * @param mixed $id
    */
    public function setCountry($country)
    { 
        $this->country = $country; 
    }
    /**
    * @return mixed
    */
    public function getCustomerNotes()
    { 
        return $this->customerNotes; 
    }
    /**
    * @param mixed $id
    */
    public function setCustomerNotes($customerNotes)
    { 
        $this->customerNotes = $customerNotes; 
    }
    /**
    * @return mixed
    */
    public function getAdminNotes()
    { 
        return $this->adminNotes; 
    }
    /**
    * @param mixed $id
    */
    public function setAdminNotes($adminNotes)
    { 
        $this->adminNotes = $adminNotes; 
    }
    /**
    * @return mixed
    */
    public function getIpAddress()
    { 
        return $this->ipAddress; 
    }
    /**
    * @param mixed $id
    */
    public function setIpAddress($ipAddress)
    { 
        $this->ipAddress = $ipAddress; 
    }
    /**
    * @return mixed
    */
    public function getTransactionId()
    { 
        return $this->transactionId; 
    }
    /**
    * @param mixed $id
    */
    public function setTransactionId($transactionId)
    { 
        $this->transactionId = $transactionId; 
    }
    /**
    * @return mixed
    */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    /**
    * @param mixed $createdAt
    */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = new \DateTime($createdAt);
    }
    /**
    * @return mixed
    */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    /**
    * @param mixed $updatedAt
    */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = new \DateTime($updatedAt);
    }

}
