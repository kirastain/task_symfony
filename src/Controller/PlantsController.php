<?php


namespace App\Controller;

use App\Service\PlantsService;
//use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\Query;

class PlantsController extends AbstractController
{
    private $plantsService;

    /**
     * @param PlantsService $plantsService
     */
    public function setPlantsService(PlantsService $plantsService)
    {
        $this->plantsService = $plantsService;
    }

    /**
     * @Route("/plants/")
     * @return Response
     */
    public function getPlants(): Response
    {
        $result = $this->plantsService->getAllPlants();
        return new Response(json_encode($result));
    }

    /**
     * @Route("/plants/{currentId}")
     * @param int $currentId
     * @return Response
     */
    public function getPlantById(int $currentId): Response
    {
        $result = $this->getDoctrine()->getRepository(Plants::class)->createQueryBuilder("c")
            ->where("c.id = $currentId")
            ->getQuery()->getResult(Query::HYDRATE_ARRAY);
        return new Response(json_encode($result));
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