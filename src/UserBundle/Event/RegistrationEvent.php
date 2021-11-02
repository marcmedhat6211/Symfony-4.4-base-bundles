<?php

namespace App\UserBundle\Event;

use App\UserBundle\Entity\User;
use App\UserBundle\Model\PNUserInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Contracts\EventDispatcher\Event;

class RegistrationEvent extends Event
{
    protected PNUserInterface $user;
    protected Request $request;

    public function __construct(PNUserInterface $user, RequestStack $requestStack)
    {
        $this->user = $user;
        $this->request = $requestStack->getCurrentRequest();
    }

    public function getUser(): PNUserInterface {
        return $this->user;
    }

    public function getRequest(): ?Request {
        return $this->request;
    }
}