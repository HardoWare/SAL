<?php

namespace App\Controller;

use App\Repository\LogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'app')]
class MainController extends AbstractController
{
    #[Route('/', name: '.main', methods: ['GET', 'HEAD'])]
    public function index(LogRepository $logRepository): Response
    {
        $logs = $logRepository->selectIntLogowZError(10);

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'logs' => $logs,
        ]);
    }
}
