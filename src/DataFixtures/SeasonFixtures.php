<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $nbSeasonReference = 0;

        for ($i=0; $i < 6 ; $i++) {
            for ($j=0; $j < 5 ; $j++) { 
                $season = new Season();
                $season->setProgram($this->getReference('program_' . $i));
                $season->setYear(2000+$j);
                $season->setNumber($j);
                $season->setDescription('Serie : '. $i .'Description saison '. $j . ' seasonRef ' .$nbSeasonReference);
                $manager->persist($season);
                $this->addReference('season_' . $nbSeasonReference , $season);
                $nbSeasonReference++;
            }
    }

        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont SeasonFixtures dépend
        return [
          ProgramFixtures::class,
        ];
    }
}

