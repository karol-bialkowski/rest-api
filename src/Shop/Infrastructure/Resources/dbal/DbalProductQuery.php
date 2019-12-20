<?php

declare(strict_types=1);

namespace App\Shop\Infrastructure\Resources\dbal;

use App\Application\Exceptions\ProductException;
use App\Shop\Application\Query\ProductQuery;
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
}