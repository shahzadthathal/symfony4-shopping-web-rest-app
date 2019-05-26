<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ProductRepository;
use App\Repository\ProductBundleItemRepository;
use App\Utils\Slugger;
use App\Entity\Product;
use App\Entity\ProductBundleItem;

final class ProductBundleService
{
    /**
    * @var ProductRepository
    */
    private $productRepository;
    private $productBundleItemRepository;
    private $slugger;
    private $em;


    public function __construct(ProductRepository $productRepository, Slugger $slugger, EntityManagerInterface $em, ProductBundleItemRepository $productBundleItemRepository){

        $this->productRepository = $productRepository;
        $this->productBundleItemRepository = $productBundleItemRepository;
        $this->slugger = $slugger;
        $this->em = $em;
    }

    public function getProductsIsNotBundles(): ?array
    {
        return $this->productRepository->findBy(['status'=>'Active', 'isProductBundle'=>'No']);

    }

    public function getProducts(): ?array
    {
        return $this->productRepository->findBy(['isProductBundle'=>'Yes'],['id'=>'DESC']);
    }

    public function getProduct($id){
    	#Find by id
    	//return $this->productRepository->find($id);
    	#Or find by slug
    	$product = $this->productRepository->findBy(['id'=>$id,'isProductBundle'=>'Yes']);

        $bunleItems = $this->productBundleItemRepository->findByProductBundleIdJoinedToProduct($product[0]->getId());

        $returnData['product'] = $product;
        $returnData['bunleItems'] = $bunleItems;
        return $returnData;
    }

    public function addProduct($params){

    	$product = new Product();
        foreach($params as $key=>$val){
        	$property = 'set'.strtoupper($key);
        	if(property_exists('App\Entity\Product',$key)){
        		$product->$property($val);
        	}
        }
    	
        $product->setIsProductBundle("Yes");

    	$slug = $this->slugger->slugify($product->getTitle());
        $product->setSlug($slug);
        $product->setCreatedAt(date("Y-m-d H:i:s"));
        $product->setUpdatedAt(date("Y-m-d H:i:s"));
        
        $this->em->persist($product);
        $this->em->flush();

        $productsArr = $params['productsArr'];

        if(count($productsArr)>0){
            foreach($productsArr as $productId){
               $productBundleItem = new ProductBundleItem();
               $productBundleItem->setProductBundleId($product->getId());
                $productBundleItem->setProductId($productId);
                $this->em->persist($productBundleItem);
                $this->em->flush();
            }
        }
        $returnData['product'] = $product;
        $returnData['productsArr'] = $productsArr;
        return $returnData;
    }

    public function updateProduct($params, $id){

    	if(empty($id))
    		return [];
    	$product = $this->productRepository->find($id);
    	if(!$product){
    		return [];
    	}
        foreach($params as $key=>$val){
        	if($key=='id')
        		continue;
        	$property = 'set'.ucfirst($key);
        	if(property_exists('App\Entity\Product',$key)){
        		$product->$property($val);
        	}
        }
    	
        $product->setIsProductBundle("Yes");
    	$slug = $this->slugger->slugify($product->getTitle());
        $product->setSlug($slug);
        $product->setUpdatedAt(date("Y-m-d H:i:s"));
        
        $this->em->persist($product);
        $this->em->flush();

        $productsArr = $params['productsArr'];

        if(count($productsArr)>0){
            foreach($productsArr as $productId){

                $isExist = $this->productBundleItemRepository->findBy(['productId'=>$productId]);
                if(!$isExist){
                    $productBundleItem = new ProductBundleItem();
                    $productBundleItem->setProductBundleId($product->getId());
                    $productBundleItem->setProductId($productId);
                    $this->em->persist($productBundleItem);
                    $this->em->flush();
                }
            }
        }

        $returnData['product'] = $product;
        $returnData['productsArr'] = $productsArr;
        return $returnData;
    }

    public function deleteProduct($id){
        $product = $this->productRepository->find($id);
        if($product){
            $productBundleItems = $this->productBundleItemRepository->findBy(['productBundleId'=>$product->getId()]);
            $this->em->remove($product);

            foreach($productBundleItems as $item){
                $this->em->remove($item);
            }

            $this->em->flush();
        }
    }
}