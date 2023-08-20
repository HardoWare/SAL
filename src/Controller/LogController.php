<?php

namespace App\Controller;

use App\Entity\Log;
use App\Form\LogType;
use App\Repository\LogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/log', name: 'app.log')]
#[IsGranted("ROLE_USER")]
class LogController extends AbstractController
{
    #[Route('/', name: '.index', methods: ['GET'])]
    public function index(LogRepository $logRepository): Response
    {
        return $this->render('log/index.html.twig', [
            'logs' => $logRepository->findAll(),
        ]);
    }

    #[Route('/new', name: '.new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $log = new Log();
        $form = $this->createForm(LogType::class, $log);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($log);
            $entityManager->flush();

            return $this->redirectToRoute('app.log.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('log/new.html.twig', [
            'log' => $log,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: '.show', methods: ['GET'])]
    public function show(Log $log): Response
    {
        return $this->render('log/show.html.twig', [
            'log' => $log,
        ]);
    }

    #[Route('/{id}/update', name: '.edit', methods: ['GET','POST'])]
    #[IsGranted("ROLE_ADMIN")]
    public function edit(Request $request, Log $log, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LogType::class, $log);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app.log.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('log/edit.html.twig', [
            'log' => $log,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: '.delete', methods: ['POST'])]
    #[IsGranted("ROLE_ADMIN")]
    public function delete(Request $request, Log $log, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$log->getId(), $request->request->get('_token'))) {
            $entityManager->remove($log);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_log_index', [], Response::HTTP_SEE_OTHER);
    }
}
