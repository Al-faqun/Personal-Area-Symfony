<?php
namespace App\Controller;

use App\Entity\Manager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends AbstractController
{

    
    public function approveManagers(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', 'Unable to access this page!');
        $em = $this->getDoctrine()->getManager();
        $messages = [];
        
        $managers = $em->getRepository(Manager::class)->findAll();
        $choices = [];
        foreach ($managers as $manager) {
            if ($manager->getUser()->hasRole('ROLE_MANAGER_PENDING')) {
                $choices[$manager->getUser()->getUsername()] = $manager->getId();
            }
        }
        $form = $this->createFormBuilder()
            ->add('managerChoice', ChoiceType::class,
                [
                    'choices' => $choices,
                    'multiple' => true,
                    'label' => false
                ])
            ->getForm();
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($form->get('managerChoice')->getData() as $choice_id) {
                $manager = $em->getRepository(Manager::class)->find($choice_id);
                if (!is_null($manager)) {
                    $manager->getUser()->addRole('ROLE_MANAGER');
                    $manager->getUser()->removeRole('ROLE_MANAGER_PENDING');
                    
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($manager);
                    $entityManager->flush();
    
                    $message = 'Успешно подтвердили менеджера ' . $manager->getUser()->getUsername();
                    $this->addFlash('success', $message);
                }
            }
            return $this->redirectToRoute('approve_manager');
        }
        
        
        return $this->render('Admin/approve_managers.html.twig', [
            'choiceForm' => $form->createView(),
            'user' => $this->getUser(),
            'errors' => [],
            'messages' => $messages
        ]);
    }
    
}