<?php

namespace App\DataFixtures;

use App\Entity\Game;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Editor;
use App\Entity\Genre;


class GameFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $gamesData = [
            [
                'name' => 'Rocket League',
                'description' => 'A high-paced hybrid of arcade-style soccer and vehicular mayhem...',
                'releaseDate' => '2015-07-07',
                'editorReference' => 'editor-0',
                'genreReferences' => ['genre-0', 'genre-3'],
            ],
            [
                'name' => 'Undertale',
                'description' => 'A unique role-playing game that allows the player to fight or talk their way through...',
                'releaseDate' => '2015-09-15',
                'editorReference' => 'editor-1',
                'genreReferences' => ['genre-1', 'genre-2'],
            ],
            [
                'name' => 'Fortnite',
                'description' => 'A battle royale game where players fight to be the last person standing...',
                'releaseDate' => '2017-07-25',
                'editorReference' => 'editor-2',
                'genreReferences' => ['genre-5', 'genre-9', 'genre-11'],
            ],
        ];

        foreach ($gamesData as $data) {
            $game = new Game();
            $game->setName($data['name']);
            $game->setDescription($data['description']);
            $game->setReleaseDate(new \DateTimeImmutable($data['releaseDate']));
            $game->setPrice(mt_rand(10, 80)); // ✅ Ajout du prix pour éviter l'erreur
            $game->setEditor($this->getReference($data['editorReference'], Editor::class));

            foreach ($data['genreReferences'] as $genreRef) {
                $game->addGenre($this->getReference($genreRef, Genre::class));
            }

            $manager->persist($game);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            EditorFixtures::class,
            GenreFixtures::class,
        ];
    }
}
