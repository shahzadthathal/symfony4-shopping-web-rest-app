<?php 

// src/Entity/ProductBundleItem.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductBundleItemRepository")
 * @ORM\Table(name="product_bundle_items")
 */
class ProductBundleItem {
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="integer")
    */
    private $productBundleId;

    /**
    * @ORM\Column(type="integer")
    */
    private $productId;


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
    public function getProductBundleId()
    { 
        return $this->productBundleId; 
    }
    /**
    * @param mixed $id
    */
    public function setProductBundleId($productBundleId)
    { 
        $this->productBundleId = $productBundleId; 
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

}
