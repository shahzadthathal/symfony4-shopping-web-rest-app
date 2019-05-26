<?php

// src/Controller/Api/ProductController.php

namespace App\Controller\Api;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\OrderService;

class CustomerOrderController extends AbstractFOSRestController
{

	private $orderService;

	public function __construct(OrderService $orderService){

		$this->orderService = $orderService;
	}

    
    /**
     * Make an estimate  and return product list with total amount
     * @Rest\Post("/customer/orders/summary")
     * @param Request $request
     * @return View
    */
    public function orderSummary(Request $request): View
    {
        $params = json_decode($request->getContent(), true);
        $orderSummary = $this->orderService->orderSummary($params);
        return View::create($orderSummary, Response::HTTP_OK);
    }

    /**
     * Make an estimate  and return product list with total amount
     * @Rest\Post("/customer/orders/save")
     * @param Request $request
     * @return View
    */

	public function saveOrder(Request $request): View
	{
        $params = json_decode($request->getContent(), true);
        $params['user'] = $this->getUser();
	    $order = $this->orderService->saveOrder($params);

	    return View::create($order, Response::HTTP_OK);
	}

    /**
     * Retrieves a Order resource
     * @Rest\Get("/customer/orders/single/{id}")
     */

    public function getOrderSingle(Request $request, $id): View
    {
        $params['id'] = $id;
        $params['userId'] = $this->getUser()->getId();
        $order = $this->orderService->getOrder($params);

        return View::create($order, Response::HTTP_OK);
    }

    /**
     * Retrieves a Orders resource
     * @Rest\Get("/customer/orders")
     */

    public function getOrders(Request $request): View
    {
        $params['userId'] = $this->getUser()->getId();
        $orders = $this->orderService->getOrders($params);

        return View::create($orders, Response::HTTP_OK);
    }

}