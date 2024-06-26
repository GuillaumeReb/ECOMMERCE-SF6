<?php

namespace App\DataFixtures;

use App\Entity\Products;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;
use Faker;

class ProductsFixtures extends Fixture
{

    public function __construct(private SluggerInterface $slugger){}

    public function load(ObjectManager $manager): void
    {
         // Permet de créer de faut produits.
        $faker = Faker\Factory::create('fr_FR');


         // La boucle FOR fais 5 faux utilisateurs
         for($prod = 1; $prod <= 10; $prod++){
            $product = new Products();
            
            $product->setName($faker->text(15));
            $product->setDescription($faker->text());
            $product->setSlug($this->slugger->slug($product->getName())->lower());
            $product->setPrice($faker->numberBetween(900, 150000));
            $product->setStock($faker->numberBetween(0, 10));

            //on va chercher une référence de catégorie
            $category = $this->getReference('cat-'. rand(1,8));
            $product->setCategories($category);

            $this->addReference('prod-'.$prod, $product); 

            $manager->persist($product);               

        }
        $manager->flush();
    }
}