<?php

declare(strict_types=1);

namespace App\Shop\Application\Command\Handler;

use App\Shop\Application\Command\IsUniqueProductName;
use App\Shop\Infrastructure\Resources\doctrine\DoctrineProducts;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class IsUniqueProductNameHandler implements MessageHandlerInterface
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
     * @param IsUniqueProductName $isUniqueProductName
     * @return bool
     */
    public function __invoke(IsUniqueProductName $isUniqueProductName)
    {

        return true;

//        $product = new Product(
//            $createNewProduct->title(),
//            $createNewProduct->price()
//        );
//
//        $this->products->add($product);
    }

}