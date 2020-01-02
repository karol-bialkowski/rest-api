<?php

declare(strict_types=1);

namespace App\Shop\Application\Command\Handler;

use App\Shop\Application\Command\DeleteProduct;
use App\Shop\Domain\Product\Entity\Product;
use App\Shop\Infrastructure\Resources\doctrine\DoctrineProducts;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class DeleteProductHandler implements MessageHandlerInterface
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
     * @param DeleteProduct $deleteProduct
     * @throws \Doctrine\ORM\ORMException
     */
    public function __invoke(DeleteProduct $deleteProduct): void
    {
        $product = $this->entityManager->getRepository(Product::class)->findOneBy(['uuid' => $deleteProduct->uuid]);

        $this->entityManager->remove($product);
        $this->entityManager->flush();
    }

}