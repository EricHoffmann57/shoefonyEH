<?php

namespace App\DataFixtures;

use App\Entity\Store\Image;
use App\Entity\Store\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private $manager;

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;
        $this->loadProducts();
        $manager->flush();
    }

    private function loadProducts(): void
    {
        for ($i = 1; $i < 15; $i++) {
            $product = new Product();
            $product->setName('Product ' . $i);
            $product->setPrice(mt_rand(10, 100));
            $product->setSlug('product' .$i);
            $product->setDescription('description courte du produit' .$i);
            $product->setLongDescription('Description longue du produit' .$i);

            $image = (new Image())
                ->setUrl('shoe-' .$i . '.jpg')
                ->setAlt($product->getName());


            $product->setImage($image);
            $product->setCreatedAt(new \DateTime());
            //$product->setLongDescription('longDescription' . $i);
            $this->manager->persist($product);
        }
    }
}
