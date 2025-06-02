<?php

namespace App\Controller;

use App\Entity\Review;
use App\Form\ReviewType;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class GameController extends AbstractController
{
    #[Route('/game', name: 'app_game')]
    public function index(GameRepository $gameRepository): Response
    {
        $games = $gameRepository->findAll();

        return $this->render('game/index.html.twig', [
            'games' => $games,
        ]);
    }

    #[Route('/game/{id}', name: 'app_game_show')]
    public function show(
        Game $game,
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $review = new Review();
        $review->setGame($game);
        $review->setCreatedAt(new \DateTimeImmutable());

        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $review->setUser($this->getUser()); // l'utilisateur connecté
            $em->persist($review);
            $em->flush();

            $this->addFlash('success', 'Avis ajouté avec succès ✅');
            return $this->redirectToRoute('app_game_show', ['id' => $game->getId()]);
        }

        return $this->render('game/show.html.twig', [
            'game' => $game,
            'reviewForm' => $form->createView(),
        ]);
    }
}
