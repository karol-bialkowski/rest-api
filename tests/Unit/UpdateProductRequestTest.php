<?php

namespace App\Tests\Unit;

use App\Shop\Application\Exceptions\ProductException;
use App\Shop\Infrastructure\Requests\UpdateProductRequest;
use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;

class UpdateProductRequestTest extends TestCase
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

    public function testShouldThrowErrorWithMissingDataToUpdate(): void
    {
        $this->expectExceptionObject(ProductException::missingAtLeastProductTitleOrPrice());
        $uuid = Uuid::uuid4()->toString();

        $this->mockRequest
            ->expects($this->any())
            ->method('getContent')
            ->will($this->returnValue('{}'));

        $this->mockRequest
            ->expects($this->any())
            ->method('get')
            ->with('id')
            ->will($this->returnValue($uuid));

        $createProductRequest = new UpdateProductRequest($this->mockRequest);
        $createProductRequest->validate();
    }
}