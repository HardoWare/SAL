<?php

namespace App\Service;

use App\Entity\RemoteHost;
use App\Repository\RemoteHostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class ApiService
{
    public function __construct(
        private readonly RemoteHostRepository    $remoteHostRepository,
        private readonly RequestStack            $requestStack,
        private readonly DatabaseInserterService $inserterService,
    )
    {
    }

    public function autoryzyjRequestIZwrocRemoteHost($hostName): ?RemoteHost
    {
        $currentRequest = $this->getCurrentRequest();
        $hostToken = $currentRequest->headers->get('X-AUTH-TOKEN');

        if ($hostToken === null || $hostName === null) {
            return null;
        }

        return $this->remoteHostRepository->getHostByNameAndToken($hostName, $hostToken);
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