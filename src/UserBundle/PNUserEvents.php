<?php

namespace App\UserBundle;

/**
 * @author Marc Medhat <marcmedhat6211@gmail.com>
 */
final class PNUserEvents
{
    /**
     * @Event("App\UserBundle\Event\RegistrationEvent")
     */
    const REGISTRATION_COMPLETED = 'pn_user.registration.completed';
}