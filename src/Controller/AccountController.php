<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Repository\GameRepository;
use App\Repository\PlayerRepository;
use App\Entity\Game;
use App\Form\GameEditType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class AccountController extends AbstractController
{
    #[Route('/account', name: 'app_account')]
    public function index(PlayerRepository $playerRepository, GameRepository $gameRepository): Response
    {

        $user = $this->getUser();

        if (!$user) {
            $this->addFlash('error', 'Vous devez vous connecter pour aller sur la page "Mon Compte" !');
            return $this->redirectToRoute('app_login');
        }

        $player = $playerRepository->find($user->getId()); // Récupère les informations du joueur connecté
        $historyGames = $gameRepository->findHistoryGamesByPlayer($player);
        $InProgressGames = $gameRepository->findInProgressGames($player);

        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
            'player' => $player,
            'historyGames' => $historyGames,
            'InProgressGames' => $InProgressGames,
        ]);
    }
    
    // Utilisation de ChatGPT car je n'arrivais pas à faire les conditions (si joueur fait partie de l'équipe et sir le match est en cours)
    #[Route('/account/game/edit/{id}', name: 'account_game_edit')]
    public function editGame(Request $request, Game $game, EntityManagerInterface $entityManager): Response
    {
        // Récupérez le joueur connecté
        $user = $this->getUser();

        // Vérifiez si le joueur fait partie de l'équipe bleue ou rouge
        $isUserInGame = false;

        // Vérifiez les compositions d'équipe bleue
        foreach ($game->getTeamBlue()->getTeamCompositions() as $composition) {
            if ($composition->getIdPlayer() === $user) {
                $isUserInGame = true;
                break;
            }
        }

        // Si le joueur n'est pas dans l'équipe bleue, vérifiez l'équipe rouge
        if (!$isUserInGame) {
            foreach ($game->getTeamRed()->getTeamCompositions() as $composition) {
                if ($composition->getIdPlayer() === $user) {
                    $isUserInGame = true;
                    break;
                }
            }
        }

        // Vérifiez si le match n'est pas déjà terminé
        $isGameNotFinished = !$game->isFinish();

        // Si le joueur ne fait pas partie du match ou si le match est déjà terminé, redirigez l'utilisateur
        if (!$isUserInGame || !$isGameNotFinished) {
            return $this->redirectToRoute('app_home');
        }

        // Créez un formulaire pour le match en utilisant GameEditType
        $form = $this->createForm(GameEditType::class, $game);
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrez les modifications du match
            $entityManager->persist($game);
            $entityManager->flush();

            // Redirigez l'utilisateur vers la page "Mon compte"
            return $this->redirectToRoute('app_account');
        }

        // Affichez le formulaire d'édition
        return $this->render('account/edit_game.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
