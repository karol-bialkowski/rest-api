<?php

namespace App\Tests\Functional;

use App\Tests\ResponseHelper;
use Faker\Factory;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CreateNewProductTest extends WebTestCase
{
    use ResponseHelper;

    /**
     * @var Generator
     */
    private Generator $faker;
    private const MISSING_REQUEST = 'Missing content request or empty data.';
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

    public function testShouldThrowErrorWithMissingContentData(): void
    {
        $this->client->request('POST', 'products');
        $response = $this->client->getResponse();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals(self::MISSING_REQUEST, $this->getDecodedMessage($response));
    }

    public function testShouldThrowErrorWithEmptyContentData(): void
    {
        $this->client->request('POST', 'products', [], [],
            ['CONTENT_TYPE' => 'application/json'],
            '{}'
        );
        $response = $this->client->getResponse();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals(self::MISSING_REQUEST, $this->getDecodedMessage($response));
    }

    public function testShouldThrowErrorWithMissingProductTitle(): void
    {
        $this->client->request('POST', 'products', [], [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"price":"123"}'
        );
        $response = $this->client->getResponse();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('Missing title', $this->getDecodedMessage($response));
    }

    public function testShouldThrowErrorWithMissingProductPrice(): void
    {
        $this->client->request('POST', 'products', [], [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"title":"Foo and bar"}'
        );
        $response = $this->client->getResponse();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('Missing price', $this->getDecodedMessage($response));
    }

    public function testShouldInsertCorrectProduct(): void
    {
        $this->client->disableReboot();
        $this->client->request('POST', 'products', [], [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"title":"Foo and bar", "price": "123"}'
        );
        $response = $this->client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('Product has been created', $this->getDecodedMessage($response));

        //once again the same product name, should be error with not unique product name:

        $this->client->disableReboot();
        $this->client->request('POST', 'products', [], [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"title":"Foo and bar", "price": "123"}'
        );
        $response = $this->client->getResponse();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertStringContainsString(
            'Product title must be a unique value, given: Foo and bar.',
            $this->getDecodedMessage($response)
        );

    }
}