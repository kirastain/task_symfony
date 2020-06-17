<?php


namespace App\Controller;

use App\Service\PlantsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Fpdf\Fpdf;


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
     * @Route("/plants/plant={currentId}")
     * @param int $currentId
     * @return Response
     */
    public function getPlantById(int $currentId): Response
    {
        $result = $this->plantsService->getPlantById($currentId);
        return new Response(json_encode($result));
    }

    /**
     * @Route("/plants/upd/{currentId}", name="update_name", methods={"POST"})
     * @param int $currentId
     * @param string $newName
     * @return Response
     */
    public function updateNameById(int $currentId, string $newName): Response
    {
        $result = $this->plantsService->updateName($currentId, $newName);
        return new Response(json_encode($result));
    }

    /**
     * @Route("/plants/pdf/")
     * @return Response
     */
    public function getPdf(): Response
    {
        $result = $this->plantsService->toPdf();
        return new Response($result->Output(), 200, array('Content-Type' => 'application/pdf'));
    }

    /**
     * @Route("/plants/xls/")
     * @return Response
     * @throws \PHPExcel_Exception
     */
    public function getXls(): Response
    {
        $result = $this->plantsService->toXls();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/vnd.ms-excel');
        $response->headers->set('Content-Disposition', 'attachment;filename="demo.xls"');
        $response->headers->set('Cache-Control', 'max-age=0');
        $response->prepare();
        $response->sendHeaders();
        $result->save('php://output');
        return ($response);
    }
}