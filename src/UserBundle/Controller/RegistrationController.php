<?php

namespace App\UserBundle\Controller;

use App\UserBundle\Entity\User;
use App\UserBundle\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_registration")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $user->setUsernameCanonical();
            $user->setEmailCanonical();
            $user->setPassword(
                $passwordEncoder->encodePassword($user, $data->getPassword())
            );

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Signed Up successfully');
            return $this->redirect($this->generateUrl('app_login'));
        }

        return $this->render('user/registration/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
