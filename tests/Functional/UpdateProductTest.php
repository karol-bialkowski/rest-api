<?php

namespace App\Tests\Functional;

use App\Shop\Domain\Product\Entity\Product;
use App\Tests\ResponseHelper;
use Faker\Factory;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UpdateProductTest extends WebTestCase
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

    public function testShouldUpdateCorrectProductTitleAndPrice()
    {
        $beforeChangeProduct = [
            'title' => 'Foo and RamPamPam',
            'price' => '123556'
        ];

        $product = new Product($beforeChangeProduct['title'], $beforeChangeProduct['price']);
        $this->em->persist($product);
        $this->em->flush();

        $afterChangedProduct = [
            'title' => 'New great product',
            'price' => 9911
        ];

        // Update product title and price
        $this->client->request('PUT', 'products/' . $product->getUuid(), [], [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($afterChangedProduct)
        );
        $response = $this->client->getResponse();


        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('Product updated.', $this->getDecodedMessage($response));

        $productResponse = $this->getProductPayload($response);

        $this->assertEquals($afterChangedProduct['title'], $productResponse->title);
        $this->assertEquals($afterChangedProduct['price'], $productResponse->price);
    }

}