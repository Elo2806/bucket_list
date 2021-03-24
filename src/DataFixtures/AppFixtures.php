<?php

namespace App\DataFixtures;

use App\Entity\Wish;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        //Crée notre faker pour générer de belles données aléatoires
        $faker = \Faker\Factory::create("fr_FR");

        //Exécute le code 200 fois
        for ($i = 0; $i < 200; $i++) {
            //Crée un wish vide
            $wish = new Wish();

            //Hydrater le wish
            $wish->setTitle($faker->sentence());
            $wish->setDescription($faker->text());
            $wish->setAuthor($faker->userName);
            $wish->setIsPublished($faker->boolean(90)); //90% qui seront true
            $wish->setDateCreated($faker->dateTimeBetween('- 2years')); //entre il y a 2 ans et now
            $wish->setLikes($faker->numberBetween(0, 250));

            //Demander à Doctrine d'enregistrer mon objet
            $manager->persist($wish);
        }
        //Exécuter le requête SQL
        $manager->flush();

    }
}
