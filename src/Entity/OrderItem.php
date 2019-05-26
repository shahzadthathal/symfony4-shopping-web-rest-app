<?php 

// src/Entity/OrderItem.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderItemRepository")
 * @ORM\Table(name="order_items")
 */
class OrderItem {
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="integer")
    */
    private $orderId;
    /**
     * @ORM\Column(type="integer", nullable=true)
    */
    private $productId;
    /**
     * @ORM\Column(type="integer")
    */
    private $quantity;
    /**
    * @Assert\NotBlank()
    * @ORM\Column(type="float", scale=2, nullable=true)
    */
    private $unitPrice;
    

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
    public function getOrderId()
    { 
        return $this->orderId; 
    }
    /**
    * @param mixed $id
    */
    public function setOrderId($orderId)
    { 
        $this->orderId = $orderId; 
    }
    /**
    * @return mixed
    */
    public function getProductId()
    { 
        return $this->productId; 
    }
    /**
    * @param mixed $id
    */
    public function setProductId($productId)
    { 
        $this->productId = $productId; 
    }
    /**
    * @return mixed
    */
    public function getQuantity()
    { 
        return $this->quantity; 
    }
    /**
    * @param mixed $id
    */
    public function setQuantity($quantity)
    { 
        $this->quantity = $quantity; 
    }
    /**
    * @return mixed
    */
    public function getUnitPrice()
    { 
        return $this->unitPrice; 
    }
    /**
    * @param mixed $id
    */
    public function setUnitPrice($unitPrice)
    { 
        $this->unitPrice = $unitPrice; 
    }

}
