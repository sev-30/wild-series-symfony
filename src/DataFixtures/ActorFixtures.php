<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ActorFixtures extends Fixture
{
        public const ACTORS = [
        'Al Pacino',
        'Robert De Niro',
        'Leonardo DiCaprio',
        'Tom Hanks',
        'Brad Pitt',
        'Jean Dujardin',
        'James Franco',
        'Jamie Foxx',
        'Jason Statham',
        'Liam Neeson',
        ];

        public function load(ObjectManager $manager)

        {
    
            foreach (self::ACTORS as $key => $actorName) {
               $actor = new Actor();
               $actor->setName($actorName);
               $manager->persist($actor);
               $this->addReference('actor_' . $key, $actor);
    
            }
    
            $manager->flush();
    
        }
    
    }