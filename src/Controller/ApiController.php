<?php

namespace App\Controller;

use App\Entity\RemoteHost;
use App\Security\Voter\ApiVoter;
use App\Service\ApiService;
use App\Service\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api', name: 'app.api')]
class ApiController extends AbstractController
{
    #[Route('/{name}', name: '.index', methods: ['POST'])]
    public function index(string $name, Request $request, ApiService $apiService, MailerService $mailerService): Response
    {
        $remoteHost = $apiService->autoryzyjRequestIZwrocRemoteHost($name);

        if (!$remoteHost) {
            return $this->json(['message' => Response::HTTP_UNAUTHORIZED]);
        }

        $body = json_decode($request->getContent(), true);
        if ($body) {
            $apiService->zapiszLogiDoBazy($remoteHost);
            $mailerService->sendMail($body);
        }
        else {
            $apiService->zapiszPolaczenieDoBazy($remoteHost);
        }

        return $this->json([
            'message' => Response::HTTP_OK,
            'body' => $body,
        ]);
    }

    #[Route('/message', name: '.message', methods: ['POST'])]
    public function message(Request $request): Response
    {
        return $this->json([
            'request' => $request
        ]);
    }
}
//  HOST_0
//  0_uni64db8a53d203d

//  HOST_1
//  1_uni64d4ba2273897