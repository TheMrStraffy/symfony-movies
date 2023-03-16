<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MovieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $movie = new Movie();
        $movie->setTitle('The Dark Knight.jpg');
        $movie->setReleaseYear(2008);
        $movie->setDescription('This is the description of The Dark Knight');
        $movie->setImagePath('the_dark_knight.jpg');
        $movie->addActor($this->getReference('actor_1'));
        $movie->addActor($this->getReference('actor_6'));
        $manager->persist($movie);
        
        $movie2 = new Movie();
        $movie2->setTitle('Joker');
        $movie2->setReleaseYear(2019);
        $movie2->setDescription('This is the description of Joker');
        $movie2->setImagePath('joker.jpg');
        $movie2->addActor($this->getReference('actor_5'));
        $movie2->addActor($this->getReference('actor_4'));
        $manager->persist($movie2);

        $movie3 = new Movie();
        $movie3->setTitle('Fight Club');
        $movie3->setReleaseYear(1999);
        $movie3->setDescription('This is the description of Fight Club');
        $movie3->setImagePath('fight_club.jpg');
        $movie3->addActor($this->getReference('actor_2'));
        $movie3->addActor($this->getReference('actor_3'));
        $manager->persist($movie3);

        $manager->flush();

    }
}
