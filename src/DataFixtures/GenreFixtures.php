<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GenreFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $genresData = [
            ['name' => 'Action'],
            ['name' => 'Adventure'],
            ['name' => 'Role-Playing'],
            ['name' => 'Sports'],
            ['name' => 'Strategy'],
            ['name' => 'Shooter'],
            ['name' => 'Simulation'],
            ['name' => 'Puzzle'],
            ['name' => 'Survival'],
            ['name' => 'Battle Royale'],
            ['name' => 'Sandbox'],
            ['name' => 'Multiplayer'],
            ['name' => 'Open World'],
            ['name' => 'Competitive'],
            ['name' => 'Narrative'],
        ];

        foreach ($genresData as $index => $data) {
            $genre = new Genre();
            $genre->setName($data['name']);
            $manager->persist($genre);

            $this->addReference('genre-' . $index, $genre);
        }

        $manager->flush();
    }
}
