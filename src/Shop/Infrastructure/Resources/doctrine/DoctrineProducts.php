<?php

declare(strict_types=1);

namespace App\Shop\Infrastructure\Resources\doctrine;

use App\Shop\Domain\Product\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineProducts
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function add(Product $product)
    {
        $this->entityManager->persist($product);
        $this->entityManager->flush();
    }
}