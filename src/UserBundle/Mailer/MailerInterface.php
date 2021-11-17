<?php

namespace App\UserBundle\Mailer;

use App\UserBundle\Model\PNUserInterface;

/**
 * @author Marc Medhat <marcmedhat6211@gmail.com>
 */
interface MailerInterface
{
    /**
     * Send email to a user to confirm the account creation.
     *
     * @param PNUserInterface $user
     */
    public function sendConfirmationEmailMessage(PNUserInterface $user);

    /**
     * Send email to a user to confirm the password reset.
     *
     * @param PNUserInterface $user
     */
    public function sendResettingEmailMessage(PNUserInterface $user);
}