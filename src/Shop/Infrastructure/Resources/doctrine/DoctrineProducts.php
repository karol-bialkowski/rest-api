<?php

declare(strict_types=1);

namespace App\Shop\Infrastructure\Resources\doctrine;

use App\Shop\Domain\Product\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineProducts
{
    /**
     * DoctrineProducts constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Product $product
     */
    public function add(Product $product)
    {
        $this->entityManager->persist($product);
        $this->entityManager->flush();
    }

    /**
     * @param Product $product
     */
    public function delete(Product $product)
    {
        $this->entityManager->remove($product);
        $this->entityManager->flush();
    }
}