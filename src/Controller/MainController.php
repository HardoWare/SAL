<?php

namespace App\Controller;

use App\Entity\Log;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'app')]
class MainController extends AbstractController
{
    #[Route('/', name: '.main', methods: ['GET', 'HEAD'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
//        $logs = $entityManager->getRepository(Log::class)->findAll();
//
//        if (!$logs) {
//            throw $this->createNotFoundException("No logs found");
//        }

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            //'logs' => $logs,
        ]);
    }
}
