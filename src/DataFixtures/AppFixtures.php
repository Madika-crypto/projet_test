<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;

use App\Entity\Product;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {


        $faker = Factory::create();

        for ($i = 1; $i < 5; $i++) {

            $category = new Category;
            $category->setName($faker->words(3, true));
            $manager->persist($category);

            for ($j = 1; $j < 20; $j++) {

                $product = new Product;
                $product
                    ->setName($faker->name())
                    ->setDescription($faker->text())
                    ->setPrice(mt_rand(100, 100000))
                    ->setCategory($category);
                $manager->persist($product);
            }
        }
        
        $admin = new User;
        $admin  
             ->setEmail("admin@localhost.com")
             ->setFirstname("admin")
             ->setPassword('$2y$13$HaMBNRdthxNdP32rknLJDeZr6HidiH3zMiBpDmQu2hMRfLo/x4GqS')
             ->setLastname("admin")
             ->setAdress("Adresse de l'entreprise")
             ->setPostCode("00000")
             ->setTown("Ville de l'entreprise")
             ->setRoles(["ROLE_ADMIN"])
             ->setIsVerified(true);
             //mdp yingyang
             $manager->persist($admin);

        $manager->flush();
    }
}


// $product = new Product();
// $manager->persist($product);
// $product->setName("produit 1");
// $product->setDescription("cours de symfony");