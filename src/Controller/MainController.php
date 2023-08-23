<?php

namespace App\Controller;

use App\Repository\LogRepository;
use App\Service\DatabaseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/', name: 'app')]
#[IsGranted("ROLE_USER")]
class MainController extends AbstractController
{
    #[Route('/', name: '.main', methods: ['GET'])]
    public function index(LogRepository $logRepository, DatabaseService $databaseService): Response
    {
        $today = $databaseService->getDzisiejseBledy();
        $today = count($today);
        $connections = $databaseService->getOstatniePolaczeniaZApi();
        $logs = $logRepository->selectIntLogowZError(5);

        return $this->render('main/index.html.twig', [
            'today' => $today,
            'connections' => $connections,
            'logs' => $logs,
        ]);
    }
}
