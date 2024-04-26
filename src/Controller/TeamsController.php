<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Team;
use App\Entity\TeamComposition;


class TeamsController extends AbstractController
{
    #[Route('/teams', name: 'app_teams')]
    public function index(TeamRepository $TeamRepository): Response
    {
        $teamSinglePlayer = $TeamRepository->findTeamsWithSinglePlayer();
        $findCompleteTeams = $TeamRepository->findCompleteTeams();

        $user = $this->getUser();

        if ($user != null) {

            $myTeams = $TeamRepository->findTeamsByUser($user);
            $teamSinglePlayer = $TeamRepository->findTeamsWithSinglePlayerConnected($user->getId());

            return $this->render('teams/index.html.twig', [
                'controller_name' => 'TeamsController',
                'teamSinglePlayer' => $teamSinglePlayer,
                'findCompleteTeams' => $findCompleteTeams,
                'myTeams' => $myTeams,
            ]);

        }else{

            return $this->render('teams/index.html.twig', [
                'controller_name' => 'TeamsController',
                'teamSinglePlayer' => $teamSinglePlayer,
                'findCompleteTeams' => $findCompleteTeams,
            ]); 

        }
    }

    #[Route('/team/join/{id}', name: 'app_join_team', methods: ['POST'])]
    public function index2(int $id, EntityManagerInterface $entityManager): Response
    {

        $user = $this->getUser();

        if ($user != null) {
            $team = $entityManager->getRepository(Team::class)->find($id);

            $teamComposition = new TeamComposition();
            $teamComposition->setIdPlayer($user);
            $teamComposition->setIdTeam($team);

            $entityManager->persist($teamComposition);
            $entityManager->flush();

            return $this->redirectToRoute('app_teams');
        }else{
            $this->addFlash('error', 'Vous devez vous connecter pour effectuer cette action !');
            return $this->redirectToRoute('app_login');
        }
    }

    #[Route('/team/quit/{id}', name: 'app_quit_team', methods: ['POST'])]
    public function index3(int $id, EntityManagerInterface $entityManager): Response
    {

        $user = $this->getUser();

        if ($user != null) {
            $team = $entityManager->getRepository(Team::class)->find($id);

            if ($team === null) {
                return $this->redirectToRoute('app_teams'); // sécurité si quelqu'un essaye de quitter une équipe qui n'existe pas
            }

            $teamComposition = $entityManager->getRepository(TeamComposition::class)
                ->findOneBy([
                    'idPlayer' => $user,
                    'idTeam' => $team
                ]);

            if ($teamComposition === null) {
                return $this->redirectToRoute('app_teams'); // sécurité si quelqu'un essaye de quitter une équipe dont il ne fait pas partie
            }

            $entityManager->remove($teamComposition); // Supprime la ligne dans la BDD
            $entityManager->flush();

            return $this->redirectToRoute('app_teams');
        }else{
            $this->addFlash('error', 'Vous devez vous connecter pour effectuer cette action !');
            return $this->redirectToRoute('app_login');
        }
    }
}
