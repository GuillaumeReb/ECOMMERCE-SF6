<?php

namespace App\DataFixtures;

use App\Entity\Images;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
//use App\DataFixtures\ImagesFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ImagesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        // Permet de créer de fausses images.
        $faker = Faker\Factory::create('fr_FR');

         // La boucle FOR fais 100 fausses images.
        for($img = 1; $img <= 100; $img++){
            $image = new Images();
            $image->setName($faker->image(null, 640, 680));
            $product = $this->getReference('prod-'.rand(1,10));
            $image->setProducts($product);
            $manager->persist($image);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ProductsFixtures::class
        ];
    }

}
