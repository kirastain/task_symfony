<?php


namespace App\Service;

use App\Entity\Plants;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use Fpdf\Fpdf;
use PDOException;

class PlantsService
{
    private $em;

    /**
     * PlantsService constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @return int|mixed|string
     */
    public function getAllPlants()
    {
        try {
            $result = $this->em->createQueryBuilder()
                ->select("p")
                ->from(Plants::class, 'p')
                ->getQuery()->getResult(Query::HYDRATE_ARRAY);
            return ($result);
        } catch (\Exception $e) {
            throw new \PDOException("Error getting data from the db\n" . $e);
        }
    }

    /**
     * @param int $currentId
     * @return int|mixed|string
     */
    public function getPlantById(int $currentId)
    {
        try {
            $result = $this->em->createQueryBuilder()
                ->select("p")
                ->from(Plants::class, 'p')
                ->where('p.id = :currentId')
                ->setParameter('currentId', $currentId)
                ->getQuery()->getResult(Query::HYDRATE_ARRAY);
            return ($result);
        } catch (\Exception $e) {
            throw new \PDOException("Error getting data from the db\n" . $e);
        }
    }

    /**
     * @param int $currentId
     * @param string $newName
     * @return int|mixed|string
     */
    public function updateName(int $currentId, string $newName)
    {
        try {
            $result = $this->em->createQueryBuilder()
                ->select("p")
                ->from(Plants::class, 'p')
                ->update('p.name = :newName')
                ->where('p.id = :currentId')
                ->setParameter('currentId', $currentId)
                ->setParameter('newName', $newName)
                ->getQuery()->getResult(Query::HYDRATE_ARRAY);
            return ($result);
        } catch (\Exception $e) {
            throw new \PDOException("Error updating plant name\n" . $e);
        }
    }

    /**
     * @return string
     * @throws PDOException
     */
    public function toPdf()
    {
        try {
            $pdf = new FPDF();
            $pdf->SetTitle('LNG Plants list');
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->AddPage('P');
            $pdf->SetDisplayMode('real', 'default');
            $pdf->SetXY(20, 20);
            $pdf->SetDrawColor(50, 60, 100);
            $pdf->Cell(180, 10, 'Main Data', 1, 0, 'C', 0);
            $pdf->SetXY(20, 30);
            $pdf->Cell(10, 10, "id", 1, 0, 'C', '0');
            $pdf->Cell(40, 10, "Plant Name", 1, 0, 'C', '0');
            $pdf->Cell(20, 10, "Year", 1, 0, 'C', '0');
            $pdf->Cell(20, 10, "Capacity", 1, 0, 'C', '0');
            $pdf->Cell(40, 10, "Owners", 1, 0, 'C', '0');
            $pdf->Cell(50, 10, "Country", 1, 0, 'C', '0');
            $pdf->SetXY(20, 40);
            $pdf->SetFont('Arial', '', 12);

            $columnId = "";
            $columnName = "";
            $columnYear = "";
            $columnCapacity = "";
            $columnOwners = "";
            $columnCountry = "";

            try {
                $result = $this->em->createQueryBuilder()
                    ->select("p")
                    ->from(Plants::class, 'p')
                    ->getQuery()->getResult(Query::HYDRATE_ARRAY);
            } catch (\PDOException $e) {
                throw new PDOException('An error occurred while getting the table\n');
            }

            foreach ($result as $row) {
                $columnId = $columnId . $row["id"] . "\n";
                $columnName = $columnName . $row["name"] . "\n";
                $columnYear = $columnYear . $row["year"] . "\n";
                $columnCapacity = $columnCapacity . $row["capacity"] . "\n";
                $columnOwners = $columnOwners . "-" . "\n";
                $columnCountry = $columnCountry . $row["country"] . "\n";
            }

            $pdf->MultiCell(10, 10, $columnId, 1, 'C', 0);
            $pdf->SetXY(30, 40);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(40, 10, $columnName, 1, 'C', 0);
            $pdf->SetXY(70, 40);
            $pdf->SetFont('Arial', '', 12);
            $pdf->MultiCell(20, 10, $columnYear, 1, 'C', 0);
            $pdf->SetXY(90, 40);
            $pdf->MultiCell(20, 10, $columnCapacity, 1, 'C', 0);
            $pdf->SetXY(110, 40);
            $pdf->MultiCell(40, 10, $columnOwners, 1, 'C', 0);
            $pdf->SetXY(150, 40);
            $pdf->MultiCell(50, 10, $columnCountry, 1, 'C', 0);

            return ($pdf);
        } catch (\PDOException $e) {
            throw new PDOException("Error while converting to PDF\n");
        }
    }
}