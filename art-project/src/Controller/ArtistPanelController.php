<?php

namespace App\Controller;

use App\Repository\CommissionRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Config\Doctrine\Orm\EntityManagerConfig;

class ArtistPanelController extends AbstractController
{
    #[Route('/panel', name: 'app_artist_panel')]
    public function index(CommissionRepository $commissionRepository, UsersRepository $usersRepository): Response
    {
        return $this->render('artist_panel/index.html.twig', [
            'commissions' => $commissionRepository->findBy([], ['created_at' => 'DESC']),
            'commissions_done' => $commissionRepository->findBy(['state' => '2'], ['created_at' => 'DESC']),
            'latest_commission' => $commissionRepository->findBy([], ['created_at' => 'DESC'], 1),
            'users' => $usersRepository->findAll(),
        ]);
    }

    #[Route('/panel/commissions', name: 'app_artist_commissions')]
    public function list(CommissionRepository $commissionRepository): Response
    {
        return $this->render('artist_panel/list.html.twig', [
            'commissions_not_accepted' => $commissionRepository->findBy(['state' => '0'], ['created_at' => 'DESC']),
            'commissions_wip' => $commissionRepository->findBy(['state' => '1'], ['created_at' => 'DESC']),
            'commissions_done' => $commissionRepository->findBy(['state' => '2'], ['created_at' => 'DESC']),
        ]);
    }

    #[Route('/panel/commission/{id}', name: 'app_artist_panel_commission_id')]
    public function show($id, CommissionRepository $commissionRepository): Response
    {
        return $this->render('artist_panel/show.html.twig', [
            'commission' => $commissionRepository->findOneBy(['id' => $id]),
        ]);
    }

    #[Route('/panel/commission/{id}/accept', name: 'commission_accept', methods: ['GET', 'POST'])]
    public function accept($id, CommissionRepository $commissionRepository, EntityManagerInterface $manager): Response
    {
        $commission = $commissionRepository->findOneBy(['id' => $id]);
        $commission->setState('1');

        $this->addFlash('success', 'Commission accepted');
        $manager->persist($commission);
        $manager->flush();

        return $this->redirectToRoute('app_artist_commissions');
    }

    #[Route('/panel/commission/{id}/done', name: 'commission_work', methods: ['GET', 'POST'])]
    public function done($id, CommissionRepository $commissionRepository, EntityManagerInterface $manager): Response
    {
        $commission = $commissionRepository->findOneBy(['id' => $id]);
        $commission->setState('2');

        $this->addFlash('success', 'Commission done');
        $manager->persist($commission);
        $manager->flush();

        return $this->redirectToRoute('app_artist_commissions');
    }
}
