<?php

namespace App\UserBundle\EventListener;

use App\UserBundle\Entity\User;
use App\UserBundle\Event\RegistrationEvent;
use App\UserBundle\PNUserEvents;
use App\UserBundle\Util\CanonicalizerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @author Marc Medhat <marcmedhat6211@gmail.com>
 */
class RegistrationListener implements EventSubscriberInterface
{
    private CanonicalizerInterface $canonicalizer;
    private EntityManagerInterface $em;

    public function __construct(CanonicalizerInterface $canonicalizer, EntityManagerInterface $em)
    {
        $this->canonicalizer = $canonicalizer;
        $this->em = $em;
    }

    public static function getSubscribedEvents()
    {
        return [
            PNUserEvents::REGISTRATION_COMPLETED => 'onRegistrationComplete',
        ];
    }

    public function onRegistrationComplete(RegistrationEvent $event)
    {
        $user = $event->getUser();
        $user->registrationValidation = [
            "error" => false,
            "message" => ""
        ];
        $this->setUsernameCanonicalAndEmailCanonical($user, $this->canonicalizer);
        $areUsernameAndEmailValid = $this->validateUsernameAndEmail($user);
        if ($areUsernameAndEmailValid["error"]) {
            $user->registrationValidation = $areUsernameAndEmailValid;
        }
    }

    //PRIVATE METHODS
    private function setUsernameCanonicalAndEmailCanonical(User $user, CanonicalizerInterface $canonicalizer): void
    {
        $user->setUsernameCanonical($canonicalizer->canonicalize($user->getUsername()));
        $user->setEmailCanonical($canonicalizer->canonicalize($user->getEmail()));
    }

    private function validateUsernameAndEmail(User $user): array
    {
        $returnValue = [
            "error" => false,
            "message" => ""
        ];

        $userByUsername = $this->em->getRepository(User::class)->findBy(['usernameCanonical' => $user->getUsernameCanonical()]);
        $userByEmail = $this->em->getRepository(User::class)->findBy(['emailCanonical' => $user->getEmailCanonical()]);

        if ($userByUsername && $userByEmail) {
            $returnValue = [
                "error" => true,
                "message" => "Another user has the same username and email"
            ];
        }

        if ($userByUsername) {
            $returnValue = [
                "error" => true,
                "message" => "Another user has the same username"
            ];
        }

        if ($userByEmail) {
            $returnValue = [
                "error" => true,
                "message" => "Another user has the same email"
            ];
        }

        return $returnValue;
    }
}