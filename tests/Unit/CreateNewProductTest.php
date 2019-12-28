<?php
//
//namespace App\Tests\Unit;
//
//use App\Shop\Application\Command\CreateNewProduct;
//use App\Shop\Application\Exceptions\ProductException;
//use App\Shop\Infrastructure\Requests\CreateProductRequest;
//use Faker\Factory;
//use Faker\Generator;
//use PHPUnit\Framework\MockObject\MockObject;
//use PHPUnit\Framework\TestCase;
//use Symfony\Component\HttpFoundation\Request;
//
//class CreateNewProductTest extends TestCase
//{
//
//    /**
//     * @var Generator
//     */
//    private Generator $faker;
//    /**
//     * @var MockObject
//     */
//    private MockObject $mockRequest;
//
//    public function setUp(): void
//    {
//        $this->mockRequest = $this
//            ->getMockBuilder(Request::class)
//            ->getMock();
//        $this->faker = Factory::create();
//    }
//
////    public function testShouldThrowProductWrongDescriptionException(): void
////    {
//////        $this->expectExceptionObject(ProductException::wrongProductTitle('a'));
//////        new CreateNewProduct('a', 0);
////    }
////
////    public function testShouldErrorWithMissingPriceParameters(): void
////    {
//////        $this->expectException(TypeError::class);
//////        new CreateNewProduct(
//////            $this->faker->realText(100),
//////            $this->faker->realText(255),
//////            null
//////        );
////    }
////
////    public function testShouldThrowErrorWithWrongPrice(): void
////    {
//////        $this->expectExceptionObject(ProductException::wrongProductPrice());
//////        new CreateNewProduct(
//////            $this->faker->realText(100),
//////            $this->faker->realText(255),
//////            8979879878978979789
//////        );
////    }
//}