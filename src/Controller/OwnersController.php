<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OwnersController
{
    /**
     * @Route("/owners")
     * @return Response
     */
    public function owners(): Response
    {
        return new Response('owners here');
    }
}