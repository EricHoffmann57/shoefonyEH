<?php

namespace App\DataFixtures;

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
        for ($i = 1; $i < 21; $i++) {
            $product = new Product();
            $product->setName('Product ' . $i);
            $product->setDescription('Description ' . $i);
            $product->setPrice(mt_rand(10, 100));
            $product->setCreatedAt(new \DateTime());
            $this->manager->persist($product);
        }
    }
}
