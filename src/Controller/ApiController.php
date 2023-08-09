<?php

namespace App\Controller;

use App\Repository\RemoteHostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'app.api')]
class ApiController extends AbstractController
{
    #[Route('/', name: '', methods: ['POST'])]
    public function index(Request $request, RemoteHostRepository $hostRepository): Response
    {
        $hostName = $request->headers->get('REMOTE_HOST');
        $hostToken = $request->headers->get('HOST_TOKEN');

        if ($hostToken === null || $hostName === null) {
            return $this->json(['message' => Response::HTTP_UNAUTHORIZED]);
        }

//        $hostExist = $hostRepository->getHostByNameAndToken($hostName, $hostToken);
//        if (!$hostExist) {
//            return $this->json(['message' => Response::HTTP_UNAUTHORIZED]);
//        }
//        $json = $request->getContent();

        $body = json_decode($request->getContent(), true);
        $content = $body['logi'];

        return $this->json([
            'message' => Response::HTTP_OK,
            'host' => $hostName,
            'token' => $hostToken,
            'body' => $body,
            'logs' => $content,
        ]);

        return $this->json(['message' => Response::HTTP_UNAUTHORIZED]);
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
