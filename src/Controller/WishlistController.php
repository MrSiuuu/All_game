<?php

namespace App\Controller;

use App\Repository\GameRepository;
use App\Repository\WishlistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class WishlistController extends AbstractController
{
    #[Route('/wishlist/add/{id}', name: 'app_wishlist_add', methods: ['POST'])]
    public function add(int $id, GameRepository $gameRepository): Response
    {
        $game = $gameRepository->find($id);

        if (!$game) {
            throw $this->createNotFoundException('Jeu introuvable');
        }

        // TODO: Ajouter la logique pour sauvegarder le jeu dans les favoris
        // Pour l'instant, on redirige simplement vers la page du jeu
        $this->addFlash('success', 'Jeu ajouté aux favoris !');

        return $this->redirectToRoute('app_game_show', ['id' => $id]);
    }

    #[Route('/wishlist', name: 'app_wishlist')]
    public function list(WishlistRepository $wishlistRepository): Response
    {
        $wishlistItems = $wishlistRepository->findBy(['user' => $this->getUser()]);

        return $this->render('wishlist/list.html.twig', [
            'wishlistItems' => $wishlistItems,
        ]);
    }
} 