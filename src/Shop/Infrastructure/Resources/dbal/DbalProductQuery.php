<?php

declare(strict_types=1);

namespace App\Shop\Infrastructure\Resources\dbal;

use App\Shop\Application\Exceptions\ProductException;
use App\Shop\Application\Exceptions\ProductNotFoundException;
use App\Shop\Application\Query\ProductQuery;
use App\Shop\Application\Query\ProductView;
use Doctrine\DBAL\Connection;

final class DbalProductQuery implements ProductQuery
{

    /**
     * @var Connection
     */
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function isUniqueTitle(string $title): bool
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->select('p.uuid')
            ->from('products', 'p')
            ->where('p.title = :productTitle')
            ->setParameter('productTitle', $title);

        $result = $queryBuilder->execute()->fetchAll();

        if (!empty($result)) {
            throw ProductException::titleIsNotUnique($title, $result[0]['uuid']);
        }

        return true;
    }

    /**
     * @param string $title
     * @return ProductView
     */
    public function getByTitle(string $title): ProductView
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->select(['p.title', 'p.price', 'p.uuid', 'p.id'])
            ->from('products', 'p')
            ->where('p.title = :productTitle')
            ->setParameter('productTitle', $title);

        $result = $queryBuilder->execute()->fetchAll();
        $result = $result[0];

        return new ProductView($result['uuid'], $result['title'], $result['price'], $result['id']);
    }

    /**
     * @param string $uuid
     * @return bool
     * @throws ProductNotFoundException
     */
    public function existProductUuid(string $uuid): bool
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->select('p.uuid')
            ->from('products', 'p')
            ->where('p.uuid = :uuid')
            ->setParameter('uuid', $uuid);

        $result = $queryBuilder->execute()->fetchAll();

        if (empty($result)) {
            throw ProductNotFoundException::byUuid($uuid);
        }

        return true;
    }

    /**
     * @param string $uuid
     * @return ProductView
     */
    public function getByUuid(string $uuid): ProductView
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->select(['p.title', 'p.price', 'p.uuid'])
            ->from('products', 'p')
            ->where('p.uuid = :uuid')
            ->setParameter('uuid', $uuid);

        $result = $queryBuilder->execute()->fetchAll();
        $result = $result[0];

        return new ProductView($result['uuid'], $result['title'], $result['price']);
    }
}