<?php

declare(strict_types=1);

namespace App\Shop\Infrastructure\Http\Controllers;

use App\Shop\Infrastructure\Resources\dbal\DbalProductQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

abstract class BaseController extends AbstractController
{
    use HandleTrait;

    /**
     * @var DbalProductQuery
     */
    protected DbalProductQuery $dbalProductQuery;

    public function __construct(MessageBusInterface $messageBus, DbalProductQuery $dbalProductQuery)
    {
        $this->messageBus = $messageBus;
        $this->dbalProductQuery = $dbalProductQuery;
    }

    /**
     * @param object $message
     * @return mixed
     */
    public function handleMessage(object $message)
    {
        return $this->handle($message);
    }

}