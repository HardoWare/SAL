<?php

namespace App\Controller;

use App\Service\ApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'app.api')]
class ApiController extends AbstractController
{
    #[Route('/', name: '', methods: ['POST'])]
    public function index(Request $request, ApiService $apiService): Response
    {
        $remoteHost = $apiService->requestAutorization($request);
        if (!$remoteHost) {
            return $this->json(['message' => Response::HTTP_UNAUTHORIZED]);
        }

        $apiService->addLogiDoBazy($request);



        $body = json_decode($request->getContent(), true);




        return $this->json([
            'message' => Response::HTTP_OK,
//            'host' => $hostName,
//            'token' => $hostToken,
            '$body' => $body,
        ]);
    }

    #[Route('/message', name: '.message', methods: ['POST'])]
    public function message(Request $request): Response
    {

        //return $request->getContent();
        return $this->json([
            'request' => $request
        ]);
    }
}
//  HOST_0
//  0_uni64db8a53d203d