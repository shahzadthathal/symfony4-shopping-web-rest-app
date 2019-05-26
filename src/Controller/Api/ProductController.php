<?php

// src/Controller/Api/ProductController.php

namespace App\Controller\Api;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\ProductService;

class ProductController extends AbstractFOSRestController
{

	private $productService;

	public function __construct(ProductService $productService){

		$this->productService = $productService;
	}

	/**
	 * Retrieves a collection of Product resource
	 * @Rest\Get("/products")
	 */

	public function getProducts(Request $request): View
	{

        $params['page'] = $request->query->getInt('page', 1);
        $params['limit'] = $request->query->getInt('limit', 10);

	    $products = $this->productService->getProducts($params);

	    return View::create($products, Response::HTTP_OK);
	}

	/**
	 * Retrieves a Product resource
	 * @Rest\Get("/products/{slug}")
	 */

	public function getProduct(Request $request, $slug): View
	{
	    $product = $this->productService->getProduct($slug);

	    return View::create($product, Response::HTTP_OK);
	}

	/**
     * Creates an Product resource
     * @Rest\Post("/products")
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
        $product = $this->productService->addProduct($params);
        return View::create($product, Response::HTTP_OK);
        
    }

    /**
     * Creates an Product resource
     * @Rest\Put("/products/{id}")
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
        $product = $this->productService->updateProduct($params, $id);
        return View::create($product, Response::HTTP_OK);
        
    }

    /**
	 * Removes the Product resource
	 * @Rest\Delete("/products/{id}")
	*/
	public function deleteProduct($id): View
    {
        $user = $this->getUser();
        if(!in_array('ROLE_ADMIN',$user->getRoles())){
            return View::create([], Response::HTTP_UNAUTHORIZED);
        }
        $this->productService->deleteProduct($id);
        return View::create([], Response::HTTP_NO_CONTENT);
        
    }
}