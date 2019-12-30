<?php

namespace App\Tests\Unit;

use App\Shop\Application\Exceptions\ApiException;
use App\Shop\Infrastructure\Helpers\IdsHelper;
use App\Shop\Infrastructure\Requests\DeleteProductRequest;
use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;

class DeleteProductRequestTest extends TestCase
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

    public function testShouldVerifyIsCorrectUuidString()
    {
        $this->assertFalse(IdsHelper::isCorrectUuid('AAAA'));
        $this->assertFalse(IdsHelper::isCorrectUuid('98a1491d-5598-a73b-67edebf03dff'));
        $this->assertFalse(IdsHelper::isCorrectUuid('a1491asdd-5598-4e4a-a73b-67edebf03dff'));
        $this->assertTrue(IdsHelper::isCorrectUuid('98a1491d-5598-4e4a-a73b-67edebf03dff'));
        $this->assertTrue(IdsHelper::isCorrectUuid(Uuid::uuid4()));
    }

    public function testShouldThrowErrorWithMissingProduct(): void
    {
        $this->expectExceptionObject(ApiException::wrongUuidStructure());
        $this->mockRequest
            ->expects($this->atLeastOnce())
            ->method('get')
            ->with('id')
            ->will($this->returnValue('AAA-BBB'));

        $createProductRequest = new DeleteProductRequest($this->mockRequest);
        $createProductRequest->validate();
    }

    public function testShouldAllowRequestNext(): void
    {
        $this->mockRequest
            ->expects($this->atLeastOnce())
            ->method('get')
            ->with('id')
            ->will($this->returnValue('98a1491d-5598-4e4a-a73b-67edebf03dff'));

        $createProductRequest = new DeleteProductRequest($this->mockRequest);
        $this->assertTrue($createProductRequest->validate());
    }


}