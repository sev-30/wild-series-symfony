<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i=0; $i < 6 ; $i++) {
        $program = new Program();
        $program->setTitle ('Série'.$i);
        $program->setSynopsis('Description série' .$i);
        $program->setCountry('Pays' .$i);
        $program->setYear('2010'.$i);
        $program->setPoster('https://img.phonandroid.com/2021/03/netflix-top-meilleures-serie-2021.jpg');
        $program->setCategory($this->getReference('category_' .$i));
        //ici les acteurs sont insérés via une boucle pour être DRY mais ce n'est pas obligatoire
        for ($j=0; $j < 6 ; $j++) {
        $program->addActor($this->getReference('actor_' . $i));

        }

        $manager->persist($program);
        $this->addReference('program_' . $i, $program);
    }
        $manager->flush();

    }

    public function getDependencies()
    {

        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend

        return [
         ActorFixtures::class,
         CategoryFixtures::class,
        ];
    }
}
