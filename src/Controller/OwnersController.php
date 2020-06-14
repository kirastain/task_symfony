<?php


namespace App\Controller;

use App\Entity\Owners;
use Doctrine\ORM\Query;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OwnersController extends AbstractController
{
    /**
     * @Route("/owners/")
     * @return Response
     */
    public function getOwners(): Response
    {
        $result = $this->getDoctrine()->getRepository(Owners::class)->createQueryBuilder('c')
            ->getQuery()->getResult(Query::HYDRATE_ARRAY);
        return new Response(json_encode($result));
    }
}