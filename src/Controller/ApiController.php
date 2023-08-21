<?php

namespace App\Controller;

use App\Entity\RemoteHost;
use App\Security\Voter\ApiVoter;
use App\Service\ApiService;
use App\Service\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Exception\JsonException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
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

        try {
            $hostrLogs = json_decode($request->getContent(), true, 10,JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            $apiService->zapiszBladPolaczenia($remoteHost, $e);
            return $this->json([
                'message' => Response::HTTP_UNPROCESSABLE_ENTITY,
            ]);
        }

        $apiService->zapiszLogiDoBazy($remoteHost);

        if ($hostrLogs[0]["status"] == "error") {
            try {
                $mailerService->sendMail($hostrLogs);
            } catch (TransportExceptionInterface $e) {
                throw new Exception($e);    //For now
            }
        }

        return $this->json([
            'message' => Response::HTTP_ACCEPTED,
            'body' => $hostrLogs,
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
//  0_uni64e113dc9965b

//  HOST_1
//