<?php

// src/Controller/Api/ProductController.php

namespace App\Controller\Api;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\ProductBundleService;

class ProductBundleController extends AbstractFOSRestController
{

	private $productBundleService;

	public function __construct(ProductBundleService $productBundleService){

		$this->productBundleService = $productBundleService;
	}

	/**
	 * Retrieves a collection of Product bundle resource
	 * @Rest\Get("/products-not-bundles")
	 */

	public function getProductsIsNotBundles(): View
	{

	    $products = $this->productBundleService->getProductsIsNotBundles();

	    return View::create($products, Response::HTTP_OK);
	}


	/**
	 * Retrieves a collection of Product bundle resource
	 * @Rest\Get("/product-bundles")
	 */

	public function getProductBundles(): View
	{

	    $products = $this->productBundleService->getProducts();

	    return View::create($products, Response::HTTP_OK);
	}

	/**
	 * Retrieves a Product bundle resource
	 * @Rest\Get("/product-bundles/{id}")
	 */

	public function getProduct(Request $request, $id): View
	{
	    $product = $this->productBundleService->getProduct($id);

	    return View::create($product, Response::HTTP_OK);
	}

	/**
     * Creates an Product bundle resource
     * @Rest\Post("/product-bundles")
     * @param Request $request
     * @return View
    */
    public function addProduct(Request $request): View
    {
    	$user = $this->getUser();
        if(!in_array('ROLE_ADMIN',$user->getRoles())){
            return View::create([], Response::HTTP_UNAUTHORIZED);
        }
    	$params = json_decode($request->getContent(), true);
        $product = $this->productBundleService->addProduct($params);
        return View::create($product, Response::HTTP_OK);
        
    }

    /**
     * Update an Product bundle resource
     * @Rest\Put("/product-bundles/{id}")
     * @param Request $request
     * @return View
    */
    public function updateProduct(Request $request, $id): View
    {
    	$user = $this->getUser();
        if(!in_array('ROLE_ADMIN',$user->getRoles())){
            return View::create([], Response::HTTP_UNAUTHORIZED);
        }
    	$params = json_decode($request->getContent(), true);
        $product = $this->productBundleService->updateProduct($params, $id);
        return View::create($product, Response::HTTP_OK);
        
    }

    /**
	 * Removes the Product bundle resource
	 * @Rest\Delete("/product-bundles/{id}")
	*/
	public function deleteProduct($id): View
    {
    	$user = $this->getUser();
        if(!in_array('ROLE_ADMIN',$user->getRoles())){
            return View::create([], Response::HTTP_UNAUTHORIZED);
        }
        $this->productBundleService->deleteProduct($id);
        return View::create([], Response::HTTP_NO_CONTENT);
        
    }
}