<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Repository\TeamRepository;

class RankingController extends AbstractController
{
    #[Route('/ranking', name: 'app_ranking')]
    public function index(TeamRepository $TeamRepository): Response
    {
        $classementTeam = $TeamRepository->classementTeam();
        // dd($classementTeam);
        return $this->render('ranking/index.html.twig', [
            'controller_name' => 'RankingController',
            'data' => $classementTeam,
        ]);
    }
}
