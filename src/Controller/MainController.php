<?php

namespace App\Controller;

use App\Repository\LogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/', name: 'app')]
class MainController extends AbstractController
{
    #[Route('/', name: '.main', methods: ['GET'])]
    public function index(LogRepository $logRepository): Response
    {
        $logs = $logRepository->selectIntLogowZError(5);

        return $this->render('main/index.html.twig', [
            'logs' => $logs,
        ]);
    }
}
