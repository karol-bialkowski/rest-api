<?php


namespace App\MainController;


use App\Shop\Infrastructure\Http\ApiResponseRepresentations\BasicResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{

    public function index()
    {
        return $this->render('homepage.html.twig');
    }

//    /**
//     * @return Response
//     */
//    public function error()
//    {
//
//        return (new BasicResponse(
//            404,
//            null,
//            'Page not found. Check out github documentation.'
//        ))->response();
//    }

}