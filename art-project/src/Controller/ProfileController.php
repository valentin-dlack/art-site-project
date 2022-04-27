<?php

namespace App\Controller;

use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(): Response
    {
        return $this->render('profile/index.html.twig');
    }

    #[Route('/profile/{id}', name: 'app_profile_id')]
    public function show($id, UsersRepository $usersRepository): Response
    {
        return $this->render('profile/show.html.twig', [
            'user' => $usersRepository->findOneBy(['id' => $id]),
            'commission' => $usersRepository->findOneBy(['id' => $id])->getCommissions(),
        ]);
    }

    #[Route('/profile/edit', name: 'app_profile_edit', methods: ['GET', 'POST'])]
    public function edit(): Response
    {
        return $this->render('profile/edit.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }
}
