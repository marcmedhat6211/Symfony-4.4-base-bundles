<?php

namespace App\UserBundle\Event;

use App\UserBundle\Model\PNUserInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * @author Marc Medhat <marcmedhat6211@gmail.com>
 */
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