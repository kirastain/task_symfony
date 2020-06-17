<?php


namespace App\Controller;

use App\Service\OwnersService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OwnersController extends AbstractController
{
    private $ownersService;

    public function __construct(OwnersService $ownersService)
    {
        $this->ownersService = $ownersService;
    }

    /**
     * @Route("/owners/")
     * @return Response
     */
    public function getOwners(): Response
    {
        $result = $this->ownersService->getAllOwners();
        return new Response(json_encode($result));
    }

    /**
     * @param int $currentId
     * @param string $newName
     * @return Response
     */
    public function updateNameById(int $currentId, string $newName): Response
    {
        $result = $this->ownersService->updateName($currentId, $newName);
        return new Response(json_encode($result));
    }
}