<?php

namespace App\Security\Voter;

use App\Repository\RemoteHostRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ApiVoter extends Voter
{
    public const INDEX = 'api.index';

    protected function __construct(
        private readonly RequestStack         $requestStack,
        private readonly RemoteHostRepository $remoteHostRepository,
    )
    {}
    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::INDEX]);
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $currentRequest = $this->requestStack->getCurrentRequest();
        $hostName = $currentRequest->headers->get('REMOTE_HOST');

        if ($hostName === null) {
            return false;
        }

        if($this->remoteHostRepository->getHostByName($hostName)) {
            return true;
        }
        return false;
    }
}
