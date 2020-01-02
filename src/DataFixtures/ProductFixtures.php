<?php

namespace App\DataFixtures;

use App\Shop\Domain\Product\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $products = [
            [
                'title' => 'Fallout',
                'price' => 199,
            ],
            [
                'title' => 'Don’t Starve',
                'price' => 299,
            ],
            [
                'title' => 'Baldur’s Gate',
                'price' => 399,
            ],
            [
                'title' => 'Icewind Dale',
                'price' => 499,
            ],
            [
                'title' => 'Bloodborne',
                'price' => 599,
            ],
        ];

        foreach ($products as $product) {
            $product = new Product($product['title'], $product['price']);
            $manager->persist($product);
        }
        $manager->flush();
    }
}
