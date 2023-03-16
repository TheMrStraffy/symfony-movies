<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ActorFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $actor = new Actor();
        $actor->setName('Christian Bale');
        $manager->persist($actor);

        $actor1 = new Actor();
        $actor1->setName('Brad Pitt');
        $manager->persist($actor1);

        $actor2 = new Actor();
        $actor2->setName('Edward Norton');
        $manager->persist($actor2);

        $actor3 = new Actor();
        $actor3->setName('Joaquin Phoenix');
        $manager->persist($actor3);

        $actor4 = new Actor();
        $actor4->setName('Robert De Niro');
        $manager->persist($actor4);

        $actor5 = new Actor();
        $actor5->setName('Tom Hardy');
        $manager->persist($actor5);
        
        
        $manager->flush();
        
        $this->addReference('actor_1', $actor);
        $this->addReference('actor_2', $actor1);
        $this->addReference('actor_3', $actor2);
        $this->addReference('actor_4', $actor3);
        $this->addReference('actor_5', $actor4);
        $this->addReference('actor_6', $actor5);
    }
}
