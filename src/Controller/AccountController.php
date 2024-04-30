<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Repository\GameRepository;
use App\Repository\PlayerRepository;
use App\Entity\Game;
use App\Form\GameEditType;
use App\Repository\TeamRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class AccountController extends AbstractController
{
    #[Route('/account', name: 'app_account')]
    public function index(PlayerRepository $playerRepository, GameRepository $gameRepository, TeamRepository $teamRepository): Response
    {

        $user = $this->getUser();

        if (!$user) {
            $this->addFlash('error', 'Vous devez vous connecter pour aller sur la page "Mon Compte" !');
            return $this->redirectToRoute('app_login');
        }

        $statPlayer = $teamRepository->StatPlayer($user->getId());
        $player = $playerRepository->find($user->getId()); // Récupère les informations du joueur connecté
        $historyGames = $gameRepository->findHistoryGamesByPlayer($player);
        $InProgressGames = $gameRepository->findInProgressGames($player);

        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
            'player' => $player,
            'historyGames' => $historyGames,
            'InProgressGames' => $InProgressGames,
            'statPlayer' => $statPlayer,
        ]);
    }
    
    // Utilisation de ChatGPT car je n'arrivais pas à faire les conditions (si joueur fait partie de l'équipe et sir le match est en cours)
    #[Route('/account/game/edit/{id}', name: 'account_game_edit')]
    public function editGame(Request $request, Game $game, EntityManagerInterface $entityManager): Response
    {

        $user = $this->getUser();
        $isUserInGame = false;

        // Vérification si le joueur fait partie d'une des équipes
        foreach ($game->getTeamBlue()->getTeamCompositions() as $composition) {
            if ($composition->getIdPlayer() === $user) {
                $isUserInGame = true;
                break;
            }
        }
        if (!$isUserInGame) {
            foreach ($game->getTeamRed()->getTeamCompositions() as $composition) {
                if ($composition->getIdPlayer() === $user) {
                    $isUserInGame = true;
                    break;
                }
            }
        }

        $isGameNotFinished = !$game->isFinish();
        if (!$isUserInGame || !$isGameNotFinished) {
            return $this->redirectToRoute('app_home');
        }

        $form = $this->createForm(GameEditType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($game->isFinish()) {
                $teamBlueScore = $game->getTeamBlueScore();
                $teamRedScore = $game->getTeamRedScore();

                if ($teamBlueScore > $teamRedScore) {
                    $game->setTeamWin($game->getTeamBlue());

                    $game->getTeamBlue()->setVictory($game->getTeamBlue()->getVictory() + 1);
                    $game->getTeamRed()->setDefeat($game->getTeamRed()->getDefeat() + 1);
                } elseif ($teamRedScore > $teamBlueScore) {
                    $game->setTeamWin($game->getTeamRed());

                    $game->getTeamRed()->setVictory($game->getTeamRed()->getVictory() + 1);
                    $game->getTeamBlue()->setDefeat($game->getTeamBlue()->getDefeat() + 1);
                } else {
                    $game->setTeamWin(null);
                }
            }

            $entityManager->persist($game);
            $entityManager->flush();

            return $this->redirectToRoute('app_account');
        }

        return $this->render('account/edit_game.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
