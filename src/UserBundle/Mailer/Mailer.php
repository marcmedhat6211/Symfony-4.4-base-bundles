<?php

namespace App\UserBundle\Mailer;

use App\UserBundle\Model\PNUserInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

/**
 * @author Marc Medhat <marcmedhat6211@gmail.com>
 */
class Mailer implements MailerInterface
{
    protected $mailer;

    protected $router;

    protected $templating;

    protected $parameters;

    public function __construct($mailer, UrlGeneratorInterface $router, Environment $templating, array $parameters)
    {
        $this->mailer = $mailer;
        $this->router = $router;
        $this->templating = $templating;
        $this->parameters = $parameters;
    }

    public function sendConfirmationEmailMessage(PNUserInterface $user)
    {
        $template = $this->parameters['confirmation.template'];
        $url = $this->router->generate('fos_user_registration_confirm', array('token' => $user->getConfirmationToken()), UrlGeneratorInterface::ABSOLUTE_URL);
    }

    public function sendResettingEmailMessage(PNUserInterface $user)
    {

    }
}