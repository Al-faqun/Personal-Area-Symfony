<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Manager;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\RegManagerForm;
use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    public function registerClient(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator): Response
    {
        $form = $this->createForm(RegistrationFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Client */
            $client = $form->getData();

            $user = new User();
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setUsergroup('client');
            $user->setUsername($form->get('username')->getData());
            $user->addRole('ROLE_CLIENT');
            //persist user first
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            //after that we can save it's id to client
            $client->setUser($user);
            $entityManager->persist($client);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            'user' => $this->getUser(),
            'errors' => [],
            'messages' => []
        ]);
    }
    
    public function registerManager(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator): Response
    {
        $form = $this->createForm(RegManagerForm::class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Manager */
            $manager = $form->getData();
            
            $user = new User();
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setUsergroup('manager');
            $user->addRole('ROLE_MANAGER_PENDING');
            $user->setUsername($form->get('username')->getData());
            
            //persist user first
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            //after that we can save it's id to client
            $manager->setUser($user);
            $entityManager->persist($manager);
            $entityManager->flush();
            
            // do anything else you need here, like send an email
            
            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }
        
        return $this->render('registration/reg_manager.html.twig', [
            'registrationForm' => $form->createView(),
            'user' => $this->getUser(),
            'errors' => [],
            'messages' => []
        ]);
    }
}
