<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Repository\TeamRepository;

class TeamsController extends AbstractController
{
    #[Route('/teams', name: 'app_teams')]
    public function index(TeamRepository $TeamRepository): Response
    {
        $teamSinglePlayer = $TeamRepository->findTeamsWithSinglePlayer();

        $user = $this->getUser();

        if ($user != null) {

            $myTeams = $TeamRepository->findTeamsByUser($user);

            return $this->render('teams/index.html.twig', [
                'controller_name' => 'TeamsController',
                'teamSinglePlayer' => $teamSinglePlayer,
                'myTeams' => $myTeams,
            ]);

        }else{

            return $this->render('teams/index.html.twig', [
                'controller_name' => 'TeamsController',
                'teamSinglePlayer' => $teamSinglePlayer,
            ]); 

        }
    }
}
