<?php

namespace App\Controller;

use App\Repository\LogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'app')]
class MainController extends AbstractController
{
    #[Route('', name: '.main', methods: ['GET', 'HEAD'])]
    public function index(LogRepository $logRepository): Response
    {
        $logs = $logRepository->selectIntLogowZError(5);

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'logs' => $logs,
        ]);
    }
    #[Route('/login', name: '.login', methods: ['GET', 'HEAD'])]
    public function login(): Response
    {


        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/mailer', name: '.mailer', methods: ['GET', 'HEAD'])]
    public function mailer(): Response
    {


        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
