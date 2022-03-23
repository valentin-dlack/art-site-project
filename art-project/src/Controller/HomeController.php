<?php

namespace App\Controller;

use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(UsersRepository $usersRepository): Response
    {
        return $this->render('home.html.twig', [
            'users' => $usersRepository->findBy([], ['Name' => 'asc'])
        ]);
    }
}
