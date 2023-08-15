<?php

namespace App\Service;

use App\Repository\LogRepository;
use App\Repository\RemoteHostRepository;

class ApiService
{
    public function __construct(
        private RemoteHostRepository $remoteHostRepository,
        private LogRepository $logRepository,
    )
    {
    }

    public function requestAutorization($request): array|bool
    {
        $hostName = $request->headers->get('REMOTE_HOST');
        $hostToken = $request->headers->get('HOST_TOKEN');

        if ($hostToken === null || $hostName === null) {
            return false;
        }

        $hostExist = $this->remoteHostRepository->getHostByNameAndToken($hostName, $hostToken);
        if ($hostExist != null) {
            return $hostExist;
        }
        else {
            return false;
        }
    }

    public function addLogiDoBazy($request): void
    {
        $logi = json_decode($request->getContent(), true);

        $this->addLogiDoBazy($logi);


        return;
    }
}