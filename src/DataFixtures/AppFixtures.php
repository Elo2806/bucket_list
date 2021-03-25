<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Wish;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        //Monter les choix de catégorie

        $choix = ['Voyage & Aventure', 'Sport', 'Entertainment', 'Relations humaines', 'Autres catégories'];
        $categories = [];
        foreach ($choix as $cat){
            $categorie = new Categorie();
            $categorie->setLibelle($cat);
            $manager->persist($categorie);
            $categories [] = $categorie;
        }

        //Crée notre faker pour générer de belles données aléatoires
        $faker = \Faker\Factory::create("fr_FR");

        //Exécute le code 200 fois pour faire des wishes
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
            $wish->setCategorie($faker->randomElement($categories));

            //Demander à Doctrine d'enregistrer mon objet
            $manager->persist($wish);
        }


        //Exécuter le requête SQL
        $manager->flush();

    }
}
