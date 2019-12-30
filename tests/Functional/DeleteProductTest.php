<?php

namespace App\Tests\Functional;

use App\Tests\ResponseHelper;
use Faker\Factory;
use Faker\Generator;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DeleteProductTest extends WebTestCase
{
    use ResponseHelper;

    /**
     * @var Generator
     */
    private Generator $faker;
    private $em;

    /**
     * @var KernelBrowser
     */
    private KernelBrowser $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->faker = Factory::create();
        $this->em = $this->client->getContainer()->get('doctrine.orm.entity_manager');
        $this->em->beginTransaction();
    }

    public function tearDown(): void
    {
        $this->em->rollback();
    }

    public function testShouldThrowErrorWithWrongUuidStructure(): void
    {
        $this->client->catchExceptions(false);
        $this->expectException(NotFoundHttpException::class);
        $this->client->request('DELETE', 'products/bad-some-uuid');
        $response = $this->client->getResponse();

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals('Page not found. Check out github documentation.', $this->getDecodedMessage($response));
    }

    public function testShouldThrowErrorWhenITryDeleteMissingProductUuid(): void
    {
        $uuid = Uuid::uuid4();
        $this->client->request('DELETE', 'products/' . $uuid);
        $response = $this->client->getResponse();

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals('Not found product with uuid: ' . $uuid, $this->getDecodedMessage($response));
    }

    public function testShouldInsertAndCorrectDeleteProduct(): void
    {
        $this->client->disableReboot();
        $this->client->request('POST', 'products', [], [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"title":"Foo and bar", "price": "123"}'
        );
        $response = $this->client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('Product has been created', $this->getDecodedMessage($response));

        //TODO: implement receive uuid breakpoint, declared temporary
        $uuid = 'd3d7abc9-3233-4821-8793-c43ba99ae8ea';

        $this->client->request('DELETE', 'products/' . $uuid);
        $response = $this->client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('Product with uuid: ' . $uuid . ' has been removed.', $this->getDecodedMessage($response));

        //TODO: implement verify if product is delected successfully
    }
}