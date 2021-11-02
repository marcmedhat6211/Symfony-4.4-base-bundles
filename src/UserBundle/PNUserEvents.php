<?php

namespace App\UserBundle;

final class PNUserEvents
{
    /**
     * @Event("App\UserBundle\Event\RegistrationEvent")
     */
    const REGISTRATION_COMPLETED = 'pn_user.registration.completed';
}