<?php

namespace App\Service;

use App\Entity\RemoteHost;
use App\Repository\RemoteHostRepository;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class ApiService
{
    public function __construct(
        private readonly RemoteHostRepository $remoteHostRepository,
        private readonly RequestStack         $requestStack,
        private readonly DatabaseService      $databaseService,
    )
    {    }

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

        $requestStatus = array_shift($hostLogs);
        switch ($requestStatus) {
            case $requestStatus["status"] == "error":
                $this->databaseService->insertLogZStatusemError($hostLogs, $remoteHost);
                break;
            case $requestStatus["status"] == "ok":
                $this->databaseService->insertPolaczenie($remoteHost);
                break;
            default:
                $errorMessage = "No status parameter, unable to read values.";
                $this->zapiszBladPolaczenia($remoteHost, $errorMessage);
        }
    }

    public function zapiszBladPolaczenia($remoteHost, $errorMessage): void
    {
        $currentRequest = $this->getCurrentRequest();
        $hostBody = "{$currentRequest->getContent()}";
        $ts = "Content: {$hostBody} \nError message: {$errorMessage}";
        $this->databaseService->insertBledyWRequescie($remoteHost, $ts);
    }

    private function getCurrentRequest(): ?Request
    {
        return $this->requestStack->getCurrentRequest();
    }

}