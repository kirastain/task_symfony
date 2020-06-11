<?php


namespace App\Controller;

use App\Entity\Plants;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
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

    /**
     * @Route("/plants", name="create_plant")
     * @return Response
     */
    public function createPlant(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $plant = new Plants();
        $plant->setName('Kenai LNG');
        $plant->setYear(1969);
        $plant->setCapacity(1.5);
        $plant->setCountry('United States');

        $entityManager->persist($plant);
        $entityManager->flush();
        return new Response('Saved new product with id '. $plant->getId());
    }
}