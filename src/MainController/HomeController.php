<?php


namespace App\MainController;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{

    public function index()
    {
        return new Response('honepage');
    }

}