<?php

namespace App\Service;

use App\Entity\RemoteHost;
use App\Repository\LogRepository;
use App\Repository\RemoteHostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class ApiService
{
    public function __construct(
        private RemoteHostRepository $remoteHostRepository,
        private LogRepository $logRepository,
        private RequestStack $requestStack,
        private DatabaseInserterService $inserterService,
    )
    {
    }

    public function requestAutorization(): ?RemoteHost
    {
        $currentRequest = $this->getCurrentRequest();
        $hostName = $currentRequest->headers->get('REMOTE_HOST');
        $hostToken = $currentRequest->headers->get('HOST_TOKEN');

        if ($hostToken === null || $hostName === null) {
            return null;
        }

        $remoteHost = $this->remoteHostRepository->getHostByNameAndToken($hostName, $hostToken);
        return $remoteHost;
    }

    public function zapiszLogiDoBazy($remoteHost): void
    {
        $currentRequest = $this->getCurrentRequest();
        $hostLogs = json_decode($currentRequest->getContent(), true);
        $this->inserterService->insertPolaczenieZLogami($hostLogs, $remoteHost);
    }
    public function zapiszPolaczenieDoBazy($remoteHost): void
    {
        $this->inserterService->insertPolaczenie($remoteHost);
    }
    private function getCurrentRequest(): ?Request
    {
        return $this->requestStack->getCurrentRequest();
    }
}