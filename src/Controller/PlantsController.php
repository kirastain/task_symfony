<?php


namespace App\Controller;

use App\Service\PlantsService;
use Exception;
use PDOException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use PHPExcel;
use PHPExcel_IOFactory;



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
     * @Route("/")
     * @return Response
     * @throws \Exception
     */
    public function getAll()
    {
        $result = $this->plantsService->getAllWithOwners();
        return new Response(json_encode($result));
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
        $xls = new PHPExcel();
        $xls->getProperties()->setCreator("Daria Fedorova")
            ->setTitle("Main Data");
        $xls->setActiveSheetIndex(0)
            ->setCellValue('A1', "id")
            ->setCellValue('B1', "Name")
            ->setCellValue('C1', "Year");

        try {
            $line = 2;
            $result = $this->plantsService->getAllPlants();
            foreach ($result as $row) {
                $xls->setActiveSheetIndex(0)
                    ->setCellValue("A$line", $row['id'])
                    ->setCellValue("B$line", $row["name"])
                    ->setCellValue("C$line", $row["year"]);
                $line += 1;
            }
            $objWriter = PHPExcel_IOFactory::createWriter($xls, 'Excel5');

            $response = new Response($objWriter->save('php://output'), 200);
            $response = new Response();
            $response->headers->set('Content-Type', 'application/vnd.ms-excel');
            $response->headers->set('Content-Disposition', 'attachment;filename="demo.xls"');
            $response->headers->set('Cache-Control', 'max-age=0');
            $response->prepare();
            $response->sendHeaders();
            return ($response);
        } catch (\PDOException $e) {
            throw new PDOException("An error occurred while converting to .xls\n");
        }
    }

    /**
     * @Route("/plants/html/")
     * @return Response
     */
    public function getHtml(): Response
    {
        $result = $this->plantsService->getAllPlants();
        $table = "";
        $table = $table .  "<table border='1'><tr><th>id</th><th>Name</th><th>Year</th><th>Capacity</th><th>Country</th></tr>";
        foreach ($result as $row) {
            $table = $table . "<tr><td>" . $row["id"] . "</td><td>" . $row["name"] . "</td><td>" . $row["year"] . "</td><td>" . $row["capacity"] . "</td><td>" . $row["country"] . "</td></tr>";
        }
        $table = $table . "</table>";
        return new Response($table);
    }

    /**
     * @Route("/plants/delete/{currentId}")
     * @param int $currentId
     * @return Response
     * @throws \Exception
     */
    public function deletePlants(int $currentId): Response //не совсем понимаю, куда здесь лучше запихнуть транзакцию
    {
        $result = $this->plantsService->deleteRows($currentId);
        return new Response(json_encode($result));
    }

    /**
     * @Route("plants/add")
     * @return Response
     * @throws Exception
     */
    public function fromCsv(): Response //не уверена, откуда в таком формате и как вытаскивать файл, поэтому пока так
    {
        $file = fopen('../data.csv', 'r'); //или лучше брать и проверять через $_FILES?
        if (isset($file)) {
            $result = $this->plantsService->getFromCsv($file);
            fclose($file);
            return new Response(json_encode($result));
        } else {
            throw new Exception("Error updating the database: " . $e);
        }
    }

    /**
     * @Route("/plants/updowners/{currentId}", methods={"POST", "GET"})
     * @param int $currentId
     * @param array $arrOwners
     * @return Response
     */
    public function updatePlantOwners(int $currentId, array $arrOwners): Response
    {
        $result = $this->plantsService->updateOwners($currentId, $arrOwners);
        return new Response(json_encode($result));
    }
}