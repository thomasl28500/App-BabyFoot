<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\Player;
use App\Form\TeamType;
use App\Entity\TeamComposition;
use App\Repository\TeamRepository;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/team')]
class TeamController extends AbstractController
{
    #[Route('/', name: 'app_team_index', methods: ['GET'])]
    public function index(TeamRepository $teamRepository): Response
    {
        return $this->render('team/index.html.twig', [
            'teams' => $teamRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_team_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $team = new Team();
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($team);
            $entityManager->flush();

            $tmp = $entityManager->getRepository(Player::class)->findOneBy(["id"=> $user->getId()]);
            // dd($tmp->findOneBy(["id"=>$user])->getId());

            $teamComposition = new TeamComposition();
            // $teamComposition->setIdPlayer($tmp);
            // $teamComposition->setIdTeam($team->getId());

            $player = $entityManager->getRepository(Player::class)->find($user->getId());
            $teamComposition->setIdPlayer($player);
            $teamObject = $entityManager->getRepository(Team::class)->find($team->getId());
            $teamComposition->setIdTeam($teamObject);
            
            $entityManager->persist($teamComposition);
            $entityManager->flush();
            return $this->redirectToRoute('app_teams', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('team/new.html.twig', [
            'team' => $team,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_team_show', methods: ['GET'])]
    public function show(Team $team): Response
    {
        return $this->render('team/show.html.twig', [
            'team' => $team,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_team_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Team $team, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }
        
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_teams', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('team/edit.html.twig', [
            'team' => $team,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_team_delete', methods: ['POST'])]
    public function delete(Request $request, Team $team, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$team->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($team);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_team_index', [], Response::HTTP_SEE_OTHER);
    }
}
