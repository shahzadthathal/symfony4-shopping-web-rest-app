<?php
	
// src/Controller/DashboardController.php

namespace App\Controller\Admin;

// ...
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin")
 */
class DashboardController extends AbstractController
{
    // ...

    /**
     * Load the site definition and redirect to the default page.
     *
     * @Route("/dashboard", name="admin_homepage")
     */
    public function indexAction()
    {
        return $this->render('admin/dashboard.html.twig');
    }
}