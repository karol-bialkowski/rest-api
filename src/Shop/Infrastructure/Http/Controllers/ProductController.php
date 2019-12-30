<?php

declare(strict_types=1);

namespace App\Shop\Infrastructure\Http\Controllers;


use App\Shop\Application\Command\CreateNewProduct;
use App\Shop\Application\Exceptions\ApiException;
use App\Shop\Application\Exceptions\ProductException;
use App\Shop\Infrastructure\Http\ApiResponseRepresentations\BasicResponse;
use App\Shop\Infrastructure\Requests\CreateProductRequest;
use App\Shop\Infrastructure\Requests\DeleteProductRequest;
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
     * @throws ProductException
     */
    public function create(Request $request)
    {
        $createProductRequest = new CreateProductRequest($request);

        try {
            $createProductRequest->validate();
            $this->dbalProductQuery->isUniqueTitle($createProductRequest->title);
        } catch (ProductException | ApiException | \Exception $e) {
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
        return new JsonResponse('deleted '.$request->get('id'));
    }

}