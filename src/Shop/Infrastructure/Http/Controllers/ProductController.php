<?php

declare(strict_types=1);

namespace App\Shop\Infrastructure\Http\Controllers;


use App\Application\Exceptions\ProductException;
use App\Shop\Application\Command\CreateNewProduct;
use App\Shop\Application\Command\IsUniqueProductName;
use App\Shop\Infrastructure\Http\ApiResponseRepresentations\BasicResponse;
use App\Shop\Infrastructure\Requests\CreateProductRequest;
use PHPUnit\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends BaseController
{

    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        return (new BasicResponse(200, null, 'listing'))->response();
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $createProductRequest = new CreateProductRequest($request);

        try {
            $createProductRequest->validate();
            $this->dbalProductQuery->isUniqueTitle($createProductRequest->title);
        } catch (ProductException | \Exception $e) {
            return (new BasicResponse(400, null, $e->getMessage()))->response();
        }

        $command = new CreateNewProduct($createProductRequest->title, $createProductRequest->price);
        $this->handleMessage($command);

        return (new BasicResponse(200, null, 'Product has been created'))->response();
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        return new JsonResponse('updated');
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function delete(Request $request)
    {
        return new JsonResponse('deleted');
    }

}