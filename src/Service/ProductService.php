<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use App\Repository\ProductRepository;
use App\Utils\Slugger;
use App\Entity\Product;

final class ProductService
{
    /**
    * @var ProductRepository
    */
    private $productRepository;
    private $slugger;
    private $em;

    public function __construct(ProductRepository $productRepository, Slugger $slugger, EntityManagerInterface $em){

        $this->productRepository = $productRepository;
        $this->slugger = $slugger;
        $this->em = $em;
    }

    public function getProducts($params): ?array
    {
        $qb = $this->productRepository->findAllQueryBuilder();
        $adapter = new DoctrineORMAdapter($qb);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage($params['limit']);
        $pagerfanta->setCurrentPage($params['page']);

        $products = [];
        foreach ($pagerfanta->getCurrentPageResults() as $result) {
            $products[] = $result;
        }

        $response =[
            'total' => $pagerfanta->getNbResults(),
            'count' => count($products),
            'products' => $products,
        ];
        return $response;


    }

    public function getProduct($slug){
    	#Find by id
    	//return $this->productRepository->find($id);
    	#Or find by slug
    	return $this->productRepository->findBy(['slug'=>$slug]);
    }

    public function addProduct($params){

    	$product = new Product();
        foreach($params as $key=>$val){
        	$property = 'set'.strtoupper($key);
        	if(property_exists('App\Entity\Product',$key)){
        		$product->$property($val);
        	}
        }
    	
    	$slug = $this->slugger->slugify($product->getTitle());
        $product->setSlug($slug);
        $product->setCreatedAt(date("Y-m-d H:i:s"));
        $product->setUpdatedAt(date("Y-m-d H:i:s"));
        
        $this->em->persist($product);
        $this->em->flush();

        return $product;
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
    	
    	$slug = $this->slugger->slugify($product->getTitle());
        $product->setSlug($slug);
        $product->setUpdatedAt(date("Y-m-d H:i:s"));
        
        $this->em->persist($product);
        $this->em->flush();

        return $product;
    }

    public function deleteProduct($id){
    	$product = $this->productRepository->find($id);
    	if($product){
    		$this->em->remove($product);
    		$this->em->flush();
    	}
    }
}