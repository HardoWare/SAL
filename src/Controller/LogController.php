<?php

namespace App\Controller;

use App\Repository\LogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/log', name: 'app.log')]
class LogController extends AbstractController
{
    #[Route('/', name: '', methods: ['GET'])]
    #[IsGranted()]
    public function index(LogRepository $logRepository): Response
    {
        $logs = $logRepository->selectIntLogowZError(30);

        return $this->render('log/index.html.twig', [
            'logs' => $logs,
        ]);
    }

    #[Route('/create', name: '.create', methods: ['GET', 'POST'])]
    public function create(): Response
    {
        return $this->render('log/create.html.twig', [
            'controller_name' => 'LogController',
        ]);
    }

    #[Route('/{id}', name: '.read', methods: ['GET'])]
    public function read(int $id, LogRepository $logRepository): Response
    {
        $log = $logRepository->find($id);

        return $this->render('log/read.html.twig', [
            'log' => $log,
        ]);
    }

    #[Route('/{id}/update', name: '.update', methods: ['GET','PUT'])]
    public function update(int $id, LogRepository $logRepository): Response
    {
        $log = $logRepository->find($id);

        return $this->render('log/update.html.twig', [
            'log' => $log,
        ]);
    }

    #[Route('/{id}/delete', name: '.delete', methods: ['DELETE'])]
    public function delete(int $id, LogRepository $logRepository): Response
    {
        $log = $logRepository->find($id);

        return $this->render('log/delete.html.twig', [

        ]);
    }
}
