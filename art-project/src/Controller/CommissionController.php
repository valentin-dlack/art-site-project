<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommissionController extends AbstractController
{
    #[Route('/commissions', name: 'app_coms')]
    public function index(): Response
    {
        return $this->render('commission/index.html.twig', [
            'controller_name' => 'CommissionController',
        ]);
    }
}
