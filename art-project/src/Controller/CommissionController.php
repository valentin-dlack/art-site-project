<?php

namespace App\Controller;

use App\Entity\Commission;
use App\Form\CommissionType;
use App\Repository\CommissionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommissionController extends AbstractController
{
    #[Route('/commissions', name: 'app_coms')]
    public function index(CommissionRepository $commissionRepository): Response
    {
        return $this->render('commission/index.html.twig', [
            'commissions' => $commissionRepository->findBy([], ['created_at' => 'DESC']),
        ]);
    }

    #[Route('/commissions/new', name: 'new_com', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $manager,
    ) : Response
    {
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
