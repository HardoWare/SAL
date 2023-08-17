<?php

namespace App\Controller;

use App\Repository\LogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    #[Route('/login', name: '.login', methods: ['GET', 'POST'])]
    public function login(): Response
    {

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/logout', name: '.logout', methods: ['GET'])]
    public function logout(): Response
    {

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
