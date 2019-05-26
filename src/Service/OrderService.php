<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\OrderRepository;
use App\Repository\OrderItemRepository;
use App\Repository\ProductRepository;;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;

final class OrderService
{
    /**
    * @var orderRepository
    */
    private $orderRepository;
    private $orderItemRepository;
    private $productRepository;
    private $em;

    public function __construct(orderRepository $orderRepository, EntityManagerInterface $em, ProductRepository $productRepository, OrderItemRepository $orderItemRepository){

        $this->orderRepository = $orderRepository;
        $this->orderItemRepository = $orderItemRepository;
        $this->productRepository = $productRepository;
        $this->em = $em;
    }

    public function orderSummary($params){
        $discount = 0;
        $orderTotalAmount = 0;
        $orderTotalItems = 0;
        $returnProductsArr = [];

        $productsIdsArr = $params['productsIdsArr'];
        foreach($productsIdsArr as $productsPostArr){

            $product = $this->productRepository->find($productsPostArr['productId']);
            if(!$product)
                continue;
            $returnProductsArr[] = $product;
            if($product->getIsDiscount()=='Yes'){
                $discountType = $product->getDiscountType();
                if($discountType=='Concrete'){
                    $discount += ($product->getDiscount() * $productsPostArr['quantity']); 
                }
                else if($discountType=='Percentage'){
                    $discountAmount = (($product->getPrice() * $product->getDiscount()) /100);
                    $discount += ($discountAmount * $productsPostArr['quantity']);
                }

                $orderTotalAmount +=  ($product->getPrice() * $productsPostArr['quantity']);
            }
            else{
                $orderTotalAmount +=  ($product->getPrice() * $productsPostArr['quantity']);
            }
            ++$orderTotalItems;
        }

        $orderTotalAmount -= $discount;
        $returnData['products'] = $returnProductsArr;
        $returnData['orderTotalAmount'] = $orderTotalAmount;
        $returnData['discount'] = $discount;
        $returnData['currencySymbol'] = "€";
        $returnData['orderTotalItems'] = $orderTotalItems;
        return $returnData;
    }

    public function saveOrder($params){

        $order = new Order();
        foreach($params as $key=>$val){
            $property = 'set'.strtoupper($key);
            if(property_exists('App\Entity\Order',$key)){
                $order->$property($val);
            }
        }

        $discount = 0;
        $orderTotalAmount = 0;
        $orderTotalItems = 0;
        $returnProductsArr = [];

        $productsIdsArr = $params['productsIdsArr'];
        foreach($productsIdsArr as $productsPostArr){

            $product = $this->productRepository->find($productsPostArr['productId']);
            if(!$product)
                continue;
            $returnProductsArr[] = $product;
            if($product->getIsDiscount()=='Yes'){
                $discountType = $product->getDiscountType();
                if($discountType=='Concrete'){
                    $discount += ($product->getDiscount() * $productsPostArr['quantity']); 
                }
                else if($discountType=='Percentage'){
                    $discountAmount = (($product->getPrice() * $product->getDiscount()) /100);
                    $discount += ($discountAmount * $productsPostArr['quantity']);
                }

                $orderTotalAmount +=  ($product->getPrice() * $productsPostArr['quantity']);
            }
            else{
                $orderTotalAmount +=  ($product->getPrice() * $productsPostArr['quantity']);
            }
            ++$orderTotalItems;
        }

        $orderTotalAmount -= $discount;

        $order->setUserId($params['user']->getId());
        $order->setTotalAmount($orderTotalAmount);
        $order->setDiscount($discount);
        $order->setTotalItems($orderTotalItems);
        $order->setOrderNumber(date("Y-m").'-'.rand(1000,9999));       
        $order->setCreatedAt(date("Y-m-d H:i:s"));
        $order->setUpdatedAt(date("Y-m-d H:i:s"));
        
        $this->em->persist($order);
        $this->em->flush();

        #Save order items
        foreach($returnProductsArr as $key=>$productRow){
            $orderItem = new OrderItem();
            $orderItem->setOrderId($order->getId());
            $orderItem->setProductId($productRow->getId());
            $orderItem->setQuantity($productsPostArr['quantity']);
            $orderItem->setUnitPrice($productRow->getPrice());
            $this->em->persist($orderItem);
            $this->em->flush();
        }

        $returnData['order'] = $order;
        $returnData['currencySymbol'] = "€";
        $returnData['products'] = $returnProductsArr;

        return $returnData;
    }

    public function getOrders($params): ?array
    {
        return $this->orderRepository->findBy(['userId'=>$params['userId']]);
    }

    public function getOrder($params){
    	$order = $this->orderRepository->findBy(['id'=>$params['id'],'userId'=>$params['userId']]);
        $orderItems = $this->orderItemRepository->findByOrderIdJoinedToProduct($order[0]->getId());
        $returnData['order'] = $order[0];
        $returnData['orderItems'] = $orderItems;
        return $returnData;
    }

    public function updateOrder($params, $id){

    	if(empty($id))
    		return [];
    	$order = $this->orderRepository->find($id);
    	if(!$order){
    		return [];
    	}
        foreach($params as $key=>$val){
        	if($key=='id')
        		continue;
        	$property = 'set'.ucfirst($key);
        	if(property_exists('App\Entity\order',$key)){
        		$order->$property($val);
        	}
        }
    	
        $order->setUpdatedAt(date("Y-m-d H:i:s"));
        
        $this->em->persist($order);
        $this->em->flush();

        return $order;
    }

    public function deleteOrder($id){
    	$order = $this->orderRepository->find($id);
    	if($order){
    		$this->em->remove($order);
    		$this->em->flush();
    	}
    }
}