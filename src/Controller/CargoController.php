<?php
namespace App\Controller;

use App\Entity\Cargo;
use App\Entity\Client;
use App\Entity\Manager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class CargoController extends AbstractController
{

    public function index(Request $request, AuthorizationCheckerInterface $authChecker, PaginatorInterface $paginator)
    {
        $messages = [];
        if ($authChecker->isGranted(['ROLE_ADMIN'])) {
            return $this->redirectToRoute('approve_manager');
            
        } elseif ($authChecker->isGranted(['ROLE_CLIENT'])) {
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $client = $em->getRepository(Client::class)->findByUserId($user->getId());
            
            $query = $em->getRepository(Cargo::class)->createQueryBuilder('c');
            $query = $query->where('c.client = :client')->setParameter('client', $client->getId());
            
            $pagination = $paginator->paginate(
                $query,
                $request->query->getInt('page', 1)/*page number*/,
                6
            );
            
            $response =  $this->render(
                'List/list.html.twig',
                array(
                    'user' => $this->getUser(),
                    'messages' => $messages,
                    'pagination'  => $pagination,
                    'caption' => 'Ваши грузы',
                    'errors' => []
                )
            );
            
        } elseif ($authChecker->isGranted(['ROLE_MANAGER'])) {
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $manager = $em->getRepository(Manager::class)->findByUserId($user->getId());
    
            $query = $em->getRepository(Cargo::class)->createQueryBuilder('c');
            $query = $query->where('c.manager = :manager')->setParameter('manager', $manager->getId());
    
            $pagination = $paginator->paginate(
                $query,
                $request->query->getInt('page', 1)/*page number*/,
                6
            );
    
            $response =  $this->render(
                'List/list.html.twig',
                array(
                    'user' => $this->getUser(),
                    'messages' => $messages,
                    'pagination'  => $pagination,
                    'caption' => 'Грузы ваших клиентов',
                    'errors' => []
                )
            );
            
        } elseif ($authChecker->isGranted(['ROLE_MANAGER_PENDING'])) {
            $messages[] = 'Ваш аккаунт требует подтверждения администратором.';
            
            $response =  $this->render(
                'List/list.html.twig',
                array(
                    'user' => $this->getUser(),
                    'messages' => $messages,
                    'caption' => 'Грузы',
                    'errors' => []
                ));
        }
        else {
            $messages[] = 'Судя по всему, вы не залогинены на нашем сайте. Только зарегистрированные пользователи с правами могут зайти на эту страницу!';
            $response =  $this->render(
                'List/list.html.twig',
                array(
                    'user' => $this->getUser(),
                    'messages' => $messages,
                    'caption' => 'Грузы',
                    'errors' => []
                ));
        }
        
        return $response;
    }
    
    
    public function new(Request $request, ValidatorInterface $validator)
    {
        $this->denyAccessUnlessGranted('ROLE_CLIENT');
        $result = false;
        
        try {
            //получим данные
            $container = trim($request->request->get('container'));
            $date = trim($request->request->get('date_arrival'));
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $client = $em->getRepository(Client::class)->findByUserId($user->getId());
            $cargo = new Cargo($container, $date, $client);
            
            //сохраним
            $errors = $validator->validate($cargo);
            if (count($errors) === 0) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($cargo);
                $entityManager->flush();
                $result = $cargo->getId();
            } else {
                $result = array('error' => $cargo->getDateArrival());//(string)$errors);
            }
        } catch (\Throwable $e) {
            $result = array('error' => $e->getMessage());
        }
        
        return $this->json($result);
    }
    
    public function setManager(Request $request, ValidatorInterface $validator)
    {
        $this->denyAccessUnlessGranted('ROLE_MANAGER');
        $result = false;
        try {
            //получим данные
            $cargoID = trim($request->request->get('cargoID'));
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $manager = $em->getRepository(Manager::class)->findByUserId($user->getId());
            $cargo = $em->getRepository(Cargo::class)->find($cargoID);
            $cargo->setManager($manager);
            $errors = $validator->validate($cargo);
            if (count($errors) === 0) {
                //сохраним
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($cargo);
                $entityManager->flush();
                $result = true;
            }
        } catch (\Throwable $e) {
            $result = array('error' => (string)$errors);
        }
    
        return $this->json($result);
    }
    
    public function edit(Request $request, ValidatorInterface $validator)
    {
        $this->denyAccessUnlessGranted('ROLE_MANAGER');
        $result = false;
        try {
            //получим данные
            $cargoID = trim($request->request->get('cargo_id'));
            $date = trim($request->request->get('date_arrival'));
            $status = trim($request->request->get('cargo_status'));
            
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $manager = $em->getRepository(Manager::class)->findByUserId($user->getId());
            $cargo = $em->getRepository(Cargo::class)->find($cargoID);
            $cargo->setDateArrival($date);
            $cargo->setStatus($status);
            
            $errors = $validator->validate($cargo);
            if (count($errors) === 0) {
                //сохраним
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($cargo);
                $entityManager->flush();
                $result = true;
            }
        } catch (\Throwable $e) {
            $result = array('error' => (string)$errors);
        }
    
        return $this->json($result);
    }
    
    public function awaiting(Request $request, PaginatorInterface $paginator)
    {
        $this->denyAccessUnlessGranted('ROLE_MANAGER');
        $errors = [];

        //получим данные
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository(Cargo::class)->createQueryBuilder('c');
        $query = $query->where('c.manager is NULL');

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1)/*page number*/,
            5
        );
        $response =  $this->render(
            'List/list.html.twig',
            array(
                'user' => $this->getUser(),
                'messages' => [],
                'pagination'  => $pagination,
                'caption' => 'Грузы, ожидающие менеджеров',
                'errors' => $errors,
                'awaiting' => true
            )
        );
    
        return $response;
    }
    
}