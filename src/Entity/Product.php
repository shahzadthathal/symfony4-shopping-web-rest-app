<?php 

// src/Entity/Product.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @ORM\Table(name="products")
 */
class Product {
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
    * @Assert\NotBlank()
    * @ORM\Column(type="string", length=150)
    */
    private $title;
    /**
     * @ORM\Column(type="text", length=150, nullable=true)
     */
    private $slug;
    /**
    * @Assert\NotBlank()
    * @ORM\Column(type="float", scale=2)
    */
    private $price;
    /**
    * @ORM\Column(type="string", length=5)
    */
    private $currency = '€';
    /**
    * @ORM\Column(type="string", length=3, options={"comment":"Yes, No"})
    */
    private $isDiscount = 'No';
    /**
    * @ORM\Column(type="string", length=10, options={"comment":"Concrete amount (-1 EUR) or by Percentage (-10%)"}, nullable=true)
    */
    private $discountType;
    /**
    * @ORM\Column(type="integer", length=5, options={"comment":"1 or 10"})
    */
    private $discount = 0;
    /**
    * @ORM\Column(type="string", length=5, options={"comment":"No, Yes, if yes then save product ids in product bundle items"})
    */
    private $isProductBundle = 'No';
    /**
     * @ORM\Column(type="text", length=150, nullable=true)
    */
    private $sku;
    /**
    * @ORM\Column(type="string", length=15, options={"comment":"Active or Pending , only Active products will display to customers"})
    */
    private $status = 'Active';
    /**
    * @ORM\Column(type="string", length=150, options={"comment":"Upload or Link of image"})
    */
    private $imageType = 'Link';
    /**
     * @ORM\Column(type="text")
     */
    private $image = 'https://via.placeholder.com/400x300.png';
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;
    /**
     * @ORM\Column(type="datetime", nullable=true)
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
    public function getTitle(): ?string
    {
        return $this->title;
    }
    /**
    * @param mixed $title
    */
    public function setTitle($title)
    {
        if (\strlen($title) < 5) {
            throw new \InvalidArgumentException('Title needs to have 5 or more characters.');
        }

        $this->title = $title;
    }
    /**
    * @return mixed
    */
    public function getSlug(): ?string
    {
        return $this->slug;
    }
    /**
    * @param mixed $slug
    */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }
    /**
    * @return mixed
    */
    public function getPrice()
    {
        return $this->price;
    }
    /**
    * @param mixed $price
    */
    public function setPrice($price)
    {
        $this->price = $price;
    }
    /**
    * @return mixed
    */
    public function getCurrency()
    {
        return $this->currency;
    }
    /**
    * @param mixed $price
    */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }
    /**
    * @return mixed
    */
    public function getIsDiscount()
    {
        return $this->isDiscount;
    }
    /**
    * @param mixed $isDiscount
    */
    public function setIsDiscount($isDiscount)
    {
        $this->isDiscount = $isDiscount;
    }
    /**
    * @return mixed
    */
    public function getDiscountType()
    {
        return $this->discountType;
    }
    /**
    * @param mixed $discountType
    */
    public function setDiscountType($discountType)
    {
        $this->discountType = $discountType;
    }
    /**
    * @return mixed
    */
    public function getDiscount()
    {
        return $this->discount;
    }
    /**
    * @param mixed $discount
    */
    public function setDiscount($discount)
    {
        $this->discount = $discount;
    }
    /**
    * @return mixed
    */
    public function getIsProductBundle()
    { 
        return $this->isProductBundle; 
    }
    /**
    * @param mixed $id
    */
    public function setIsProductBundle($isProductBundle)
    { 
        $this->isProductBundle = $isProductBundle; 
    }
    /**
    * @return mixed
    */
    public function getSku(): ?string
    {
        return $this->sku;
    }
    /**
    * @param mixed $sku
    */
    public function setSku($sku)
    {
        $this->sku = $sku;
    }
    /**
    * @return mixed
    */
    public function getStatus(): ?string
    {
        return $this->status;
    }
    /**
    * @param mixed $status
    */
    public function setStatus($status)
    {
        $this->status = $status;
    }
    /**
    * @return mixed
    */
    public function getImageType(): ?string
    {
        return $this->imageType;
    }
    /**
    * @param mixed $imageType
    */
    public function setImageType($imageType)
    {
        $this->imageType = $imageType;
    }
    /**
    * @return mixed
    */
    public function getImage(): ?string
    {
        return $this->image;
    }
    /**
    * @param mixed $image
    */
    public function setImage($image)
    {
        $this->image = $image;
    }
    /**
    * @return mixed
    */
    public function getDescription(): ?string
    {
        return $this->description;
    }
    /**
    * @param mixed $description
    */
    public function setDescription($description)
    {
        $this->description = $description;
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
