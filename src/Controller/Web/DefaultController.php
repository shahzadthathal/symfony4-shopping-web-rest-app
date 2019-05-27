<?php
	
// src/Controller/DefaultController.php

namespace App\Controller\Web;

// ...
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\ProductService;

class DefaultController extends AbstractController
{
    // ...

    /**
     * Load the site definition and redirect to the default page.
     *
     * @Route("/", name="app_homepage")
     */
    public function indexAction(ProductService $productService)
    {
        $params['page'] = 1;
        $params['limit'] = 30;
        $products = $productService->getProducts($params);
        return $this->render('default/index.html.twig',['products'=>$products]);
    }
}