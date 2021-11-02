<?php

namespace App\UserBundle\Controller;

use App\UserBundle\Entity\User;
use App\UserBundle\Event\RegistrationEvent;
use App\UserBundle\Form\RegistrationType;
use App\UserBundle\PNUserEvents;
use App\UserBundle\Security\CustomAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{

    /**
     * @Route("/register", name="app_registration")
     */
    public function register(
        Request                      $request,
        RequestStack                 $requestStack,
        UserPasswordEncoderInterface $passwordEncoder,
        EventDispatcherInterface     $eventDispatcher,
        EntityManagerInterface       $em,
        CustomAuthenticator          $authenticator,
        GuardAuthenticatorHandler    $guard
    ): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $user->setPassword(
                $passwordEncoder->encodePassword($user, $formData->getPassword())
            );

            //dispatching an event that the registration is completed
            $event = new RegistrationEvent($user, $requestStack);
            $eventDispatcher->dispatch($event, PNUserEvents::REGISTRATION_COMPLETED);
            if ($user->registrationValidation["error"]) {
                $this->addFlash("danger", $user->registrationValidation["message"]);
                return $this->redirect($this->generateUrl('app_registration'));
            }

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Signed Up successfully');

            //Login after Registration is complete
            return $guard->authenticateUserAndHandleSuccess($user, $request, $authenticator, 'main');
        }

        return $this->render('user/registration/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
