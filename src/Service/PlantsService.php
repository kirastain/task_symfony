<?php


namespace App\Service;

use App\Entity\Plants;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;

class PlantsService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

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
}