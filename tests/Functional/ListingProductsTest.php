<?php

namespace App\Tests\Functional;

use App\Shop\Domain\Product\DTO\ProductPagination;
use App\Tests\ResponseHelper;
use Faker\Factory;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ListingProductsTest extends WebTestCase
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

    public function testShouldThrowErrorWithMissingContentData(): void
    {

        //create three some products
        for ($i = 1; $i <= 3; $i++) {
            $this->client->disableReboot();
            $this->client->request('POST', 'products', [], [],
                ['CONTENT_TYPE' => 'application/json'],
                '{"title":"Random-Product-' . $i . '", "price": "123"}'
            );
        }

        $this->client->request('GET', 'products');
        $response = $this->client->getResponse();

        $responseProducts = json_decode($response->getContent())->payload->products;

        $this->assertEquals(200, $response->getStatusCode());

        //verify if received correct products
        $this->assertEquals(count($responseProducts), ProductPagination::PRODUCTS_PER_PAGE);

        //verify if received new generated products ( descending sort )
        $this->assertEquals($responseProducts[0]->title, 'Random-Product-3');
        $this->assertEquals($responseProducts[1]->title, 'Random-Product-2');
        $this->assertEquals($responseProducts[2]->title, 'Random-Product-1');

    }
}