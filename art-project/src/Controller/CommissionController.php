<?php

namespace App\Controller;

use App\Entity\Commission;
use App\Form\CommissionType;
use App\Repository\CommissionRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommissionController extends AbstractController
{
    #[Route('/commissions', name: 'app_coms')]
    public function index(CommissionRepository $commissionRepository, UsersRepository $usersRepository): Response
    {
        return $this->render('commission/index.html.twig', [
            'commissions' => $commissionRepository->findBy([], ['created_at' => 'DESC']),
            'artist' => $usersRepository->findBy(['user_state' => 1], []),
        ]);
    }

    #[Route('/commissions/new', name: 'new_com', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $manager,
        UsersRepository $usersRepository,
    ) : Response
    {
        $artist = $usersRepository->findBy(['user_state' => 1], []);
        if ($artist[0]->getComsState() == 0) {
            return $this->redirectToRoute('app_coms');
        }
        $commission = new Commission();
        $form = $this->createForm(CommissionType::class, $commission);

        $commission->setUser($this->getUser());
        $commission->setState('0');

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $commission = $form->getData();

            $commission->setTitle($commission->getTitle() . ' - ' . $commission->getUser()->getName());

            $manager->persist($commission);
            $manager->flush();
        }

        return $this->render('commission/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
