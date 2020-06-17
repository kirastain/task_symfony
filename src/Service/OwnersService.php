<?php


namespace App\Service;

use App\Entity\Owners;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;

class OwnersService
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
    public function getAllOwners()
    {
        try {
            $result = $this->em->createQueryBuilder()
                ->select("p")
                ->from(Owners::class, 'p')
                ->getQuery()->getResult(Query::HYDRATE_ARRAY);
            return ($result);
        } catch (\Exception $e) {
            throw new \PDOException("Error getting data from the db\n" . $e);
        }
    }
}