<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameType;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Repository\TeamRepository;

#[Route('/game')]
class GameController extends AbstractController
{
    // #[Route('/', name: 'app_game_index', methods: ['GET'])]
    // public function index(GameRepository $gameRepository): Response
    // {
    //     return $this->render('game/index.html.twig', [
    //         'games' => $gameRepository->findAll(),
    //     ]);
    // }

    #[Route('/new', name: 'app_game_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, TeamRepository $teamRepository): Response
    {
        $user = $this->getUser();

        if (!$user) {
            $this->addFlash('error', 'Vous devez vous connecter pour effectuer cette action !');
            return $this->redirectToRoute('app_login');
        }

        $userTeams = $teamRepository->findTeamsByUser($user);
        if (count($userTeams) === 0) {
            $this->addFlash('error', 'Vous devez avoir au moins une équipe pour créer un match !');
            return $this->redirectToRoute('app_team_new');
        }

        $game = new Game();
        $form = $this->createForm(GameType::class, $game, ['user' => $user]); // Création de la Form avec le User connecté en param
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($game);
            $entityManager->flush();

            return $this->redirectToRoute('app_games', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('game/new.html.twig', [
            'game' => $game,
            'form' => $form,
        ]);
    }

    // #[Route('/{id}', name: 'app_game_show', methods: ['GET'])]
    // public function show(Game $game): Response
    // {
    //     return $this->render('game/show.html.twig', [
    //         'game' => $game,
    //     ]);
    // }

    // #[Route('/{id}/edit', name: 'app_game_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Game $game, EntityManagerInterface $entityManager): Response
    // {
        
    //     $form = $this->createForm(GameType::class, $game);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_game_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('game/edit.html.twig', [
    //         'game' => $game,
    //         'form' => $form,
    //     ]);
    // }

    // #[Route('/{id}', name: 'app_game_delete', methods: ['POST'])]
    // public function delete(Request $request, Game $game, EntityManagerInterface $entityManager): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$game->getId(), $request->getPayload()->get('_token'))) {
    //         $entityManager->remove($game);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('app_game_index', [], Response::HTTP_SEE_OTHER);
    // }
}
