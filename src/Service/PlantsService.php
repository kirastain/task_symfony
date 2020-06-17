<?php


namespace App\Service;

use App\Entity\Plants;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;

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
}