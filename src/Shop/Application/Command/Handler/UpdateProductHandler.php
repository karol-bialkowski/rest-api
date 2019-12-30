<?php

declare(strict_types=1);

namespace App\Shop\Application\Command\Handler;

use App\Shop\Application\Command\UpdateProduct;
use App\Shop\Infrastructure\Resources\doctrine\DoctrineProducts;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class UpdateProductHandler implements MessageHandlerInterface
{

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var DoctrineProducts
     */
    private DoctrineProducts $products;

    /**
     * CreateNewProductHandler constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->products = new DoctrineProducts($this->entityManager); //TODO: refactor this to more sexy
    }

    /**
     * @param UpdateProduct $updateProduct
     */
    public function __invoke(UpdateProduct $updateProduct): void
    {
        $sql = $this->products->update($updateProduct->uuid, $updateProduct->columns_to_update);
    }

}