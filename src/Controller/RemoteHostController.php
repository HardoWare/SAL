<?php

namespace App\Controller;

use App\Entity\RemoteHost;
use App\Form\RemoteHostType;
use App\Repository\RemoteHostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/remote_host', name: 'app.remote_host')]
#[IsGranted("ROLE_ADMIN")]
class RemoteHostController extends AbstractController
{
    #[Route('/', name: '.index', methods: ['GET'])]
    public function index(RemoteHostRepository $remoteHostRepository): Response
    {
        return $this->render('remote_host/index.html.twig', [
            'remote_hosts' => $remoteHostRepository->findAll(),
        ]);
    }

    #[Route('/new', name: '.new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $remoteHost = new RemoteHost();
        $form = $this->createForm(RemoteHostType::class, $remoteHost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($remoteHost);
            $entityManager->flush();

            return $this->redirectToRoute('app_remote_host_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('remote_host/new.html.twig', [
            'remote_host' => $remoteHost,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: '.show', methods: ['GET'])]
    public function show(RemoteHost $remoteHost): Response
    {
        return $this->render('remote_host/show.html.twig', [
            'remote_host' => $remoteHost,
        ]);
    }

    #[Route('/{id}/edit', name: '.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RemoteHost $remoteHost, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RemoteHostType::class, $remoteHost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_remote_host_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('remote_host/edit.html.twig', [
            'remote_host' => $remoteHost,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: '.delete', methods: ['POST'])]
    public function delete(Request $request, RemoteHost $remoteHost, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$remoteHost->getId(), $request->request->get('_token'))) {
            $entityManager->remove($remoteHost);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_remote_host_index', [], Response::HTTP_SEE_OTHER);
    }
}
