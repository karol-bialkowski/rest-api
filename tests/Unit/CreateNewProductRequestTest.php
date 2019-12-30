<?php

namespace App\Tests\Unit;

use App\Shop\Application\Exceptions\ProductException;
use App\Shop\Infrastructure\Requests\CreateProductRequest;
use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class CreateNewProductRequestTest extends TestCase
{

    /**
     * @var Generator
     */
    private Generator $faker;
    /**
     * @var MockObject
     */
    private MockObject $mockRequest;

    public function setUp(): void
    {
        $this->mockRequest = $this
            ->getMockBuilder(Request::class)
            ->getMock();
        $this->faker = Factory::create();
    }

    public function testShouldThrowErrorWithMissingPriceInRequest(): void
    {
        $this->expectExceptionObject(ProductException::missingKey('price'));

        $this->mockRequest
            ->expects($this->any())
            ->method('getContent')
            ->will($this->returnValue('{"title":"Another product other 2"}'));

        $createProductRequest = new CreateProductRequest($this->mockRequest);
        $createProductRequest->validate();
    }

    public function testShouldThrowErrorWithMissingProductTitleInRequest(): void
    {
        $this->expectExceptionObject(ProductException::missingKey('title'));
        $this->mockRequest
            ->expects($this->any())
            ->method('getContent')
            ->will($this->returnValue('{"price": "12"}'));

        $createProductRequest = new CreateProductRequest($this->mockRequest);
        $createProductRequest->validate();
    }

    public function testShouldThrowErrorWithTooShortProductTitleInRequest(): void
    {
        $productTitle = '.';
        $this->expectExceptionObject(ProductException::wrongProductTitle($productTitle));
        $this->mockRequest
            ->expects($this->any())
            ->method('getContent')
            ->will($this->returnValue('{"title":"' . $productTitle . '", "price": "11"}'));

        $createProductRequest = new CreateProductRequest($this->mockRequest);
        $createProductRequest->validate();
    }


    public function testShouldThrowErrorWithTooLongProductTitleInRequest(): void
    {
        $longTitle = $this->faker->realText(200);
        $tooLongProductTitle = json_encode([
            'title' => $longTitle,
            'price' => 9
        ]);

        $this->expectExceptionObject(ProductException::wrongProductTitle($longTitle));
        $this->mockRequest
            ->expects($this->any())
            ->method('getContent')
            ->will($this->returnValue($tooLongProductTitle));

        $createProductRequest = new CreateProductRequest($this->mockRequest);
        $createProductRequest->validate();
    }

    public function testShouldThrowErrorWithWrongProductPriceStructureInRequest(): void
    {
        $wrongPrice = '001ff.10'; //if you pass this e.g. (int)'001ff.10' you will get error, because php replace this to int(1), so this validation is important

        $wrongPriceRequest = json_encode([
            'title' => $this->faker->realText(50),
            'price' => $wrongPrice
        ]);

        $this->expectExceptionObject(ProductException::wrongPriceStructure($wrongPrice));
        $this->mockRequest
            ->expects($this->any())
            ->method('getContent')
            ->will($this->returnValue($wrongPriceRequest));

        $createProductRequest = new CreateProductRequest($this->mockRequest);
        $createProductRequest->validate();
    }


    public function testShouldThrowErrorWithExceededPriceRangeRequest(): void
    {
        $wrongPrice = 2147483648; //if you pass this e.g. (int)'001ff.10' you will get error, because php replace this to int(1), so this validation is important

        $wrongPriceRequest = json_encode([
            'title' => $this->faker->realText(50),
            'price' => $wrongPrice
        ]);

        $this->expectExceptionObject(ProductException::wrongPriceRange($wrongPrice));
        $this->mockRequest
            ->expects($this->any())
            ->method('getContent')
            ->will($this->returnValue($wrongPriceRequest));

        $createProductRequest = new CreateProductRequest($this->mockRequest);
        $createProductRequest->validate();
    }


    public function testShouldAllowInsertNewProductWithoutExceptions(): void
    {
        $wrongPrice = json_encode([
            'title' => $this->faker->realText(50),
            'price' => 9998
        ]);

        $this->mockRequest
            ->expects($this->any())
            ->method('getContent')
            ->will($this->returnValue($wrongPrice));

        $createProductRequest = new CreateProductRequest($this->mockRequest);
        $this->assertTrue($createProductRequest->validate());
    }
}