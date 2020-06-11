<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlantsController
{
    /**
     * @Route("/")
     * @return Response
     */
    public function plants(): Response
    {
        return new Response('blablabla');
    }
}