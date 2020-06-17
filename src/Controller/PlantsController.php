<?php


namespace App\Controller;

use App\Entity\Plants;
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
     * @param PlantsService $plantService
     */
    public function __construct(PlantsService $plantService)
    {
        $this->plantsService = $plantService;
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
        $result = $this->plantsService->getPlantById($currentId);
        return new Response(json_encode($result));
    }

    /**
     * @Route("/plants/{currentId}", name="update_name")
     * @param int $currentId
     * @param string $newName
     * @return Response
     */
    public function updateNameById(int $currentId, string $newName)
    {
        $result = $this->plantsService->updateName($currentId, $newName);
        return new Response(json_encode($result));
    }

    /**
     * @Route("/plants", name="create_plant", methods={"POST"})
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