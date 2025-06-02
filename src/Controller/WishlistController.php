<?php

namespace App\Controller;

use App\Repository\GameRepository;
use App\Repository\WishlistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Wishlist;

final class WishlistController extends AbstractController
{
    #[Route('/wishlist/add/{id}', name: 'app_wishlist_add', methods: ['POST'])]
    public function add(int $id, GameRepository $gameRepository, EntityManagerInterface $em): Response
    {
        $game = $gameRepository->find($id);

        if (!$game) {
            throw $this->createNotFoundException('Jeu introuvable');
        }

        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('error', 'Vous devez être connecté pour ajouter aux favoris.');
            return $this->redirectToRoute('app_game_show', ['id' => $id]);
        }

        // Vérifier si déjà en favoris
        foreach ($user->getWishlists() as $wishlist) {
            if ($wishlist->getGame() === $game) {
                $this->addFlash('info', 'Ce jeu est déjà dans vos favoris.');
                return $this->redirectToRoute('app_game_show', ['id' => $id]);
            }
        }

        $wishlist = new Wishlist();
        $wishlist->setUser($user);
        $wishlist->setGame($game);

        $em->persist($wishlist);
        $em->flush();

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