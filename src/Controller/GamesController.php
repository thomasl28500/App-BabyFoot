<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Repository\GameRepository;

class GamesController extends AbstractController
{
    #[Route('/games', name: 'app_games')]
    public function index(GameRepository $gameRepository): Response
    {
        $data = $gameRepository->findMostRecentMatch();
        $dataNext = $gameRepository->findNextMatch();
        // dd($dataNext);
        return $this->render('games/index.html.twig', [
            'controller_name' => 'GamesController',
            'data' => $data,
            'dataNext' => $dataNext,
        ]);
    }
}
