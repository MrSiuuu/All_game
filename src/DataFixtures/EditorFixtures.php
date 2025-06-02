<?php

namespace App\DataFixtures;

use App\Entity\Editor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EditorFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $editorsData = [
            ['name' => 'Psyonix'],
            ['name' => 'Toby Fox'],
            ['name' => 'Epic Games'],
            ['name' => 'PUBG Corporation'],
            ['name' => 'Rockstar Games'],
            ['name' => 'CD Projekt'],
            ['name' => 'Mojang'],
            ['name' => 'InnerSloth'],
            ['name' => 'Valve Corporation'],
            ['name' => 'Riot Games'],
            ['name' => 'Blizzard Entertainment'],
            ['name' => 'Bethesda Game Studios'],
        ];

        foreach ($editorsData as $index => $data) {
            $editor = new Editor();
            $editor->setName($data['name']);
            $manager->persist($editor);

            $this->addReference('editor-' . $index, $editor);
        }

        $manager->flush();
    }
}
