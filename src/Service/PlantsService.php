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
        /*$result = $this->em->createQueryBuilder()
            ->select('*')
            ->from(Plants::class, '*')
            ->getQuery()->getResult(Query::HYDRATE_ARRAY);*/
        return ("OK service");
    }
}