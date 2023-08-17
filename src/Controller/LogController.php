<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/log', name: 'app.log')]
class LogController extends AbstractController
{
    #[Route('', name: '', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('log/index.html.twig', [
            'controller_name' => 'LogController',
        ]);
    }

    #[Route('/create', name: '.create', methods: ['GET'])]
    public function create(): Response
    {
        return $this->render('log/create.html.twig', [
            'controller_name' => 'LogController',
        ]);
    }

    #[Route('/{id}', name: '.{id}', methods: ['GET', 'HEAD'])]
    public function read(): Response
    {
        return $this->render('log/index.html.twig', [
            'controller_name' => 'LogController',
        ]);
    }

    #[Route('/{id}/update', name: '.{id}.update', methods: ['PUT'])]
    public function update(): Response
    {
        return $this->render('log/index.html.twig', [
            'controller_name' => 'LogController',
        ]);
    }

    #[Route('/{id}/delete', name: '.{id}.delete', methods: ['DELETE'])]
    public function delete(): Response
    {
        return $this->render('log/index.html.twig', [
            'controller_name' => 'LogController',
        ]);
    }
}
