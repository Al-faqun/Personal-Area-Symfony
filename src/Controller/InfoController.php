<?php
namespace App\Controller;

use App\Entity\Client;
use App\Entity\Manager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;

class InfoController extends AbstractController
{
    
    
    public function manager($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $manager = $em->getRepository(Manager::class)->find($id);
        if (is_null($manager)) {
            $response = false;
        } else {
            $response = [
                'name' => $manager->getName(),
                'surname' => $manager->getSurname(),
                'email' => $manager->getEmail(),
                'tel' => $manager->getTel(),
            ];
        }
        
        return $this->json($response);
    }
    
    public function client($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $client = $em->getRepository(Client::class)->find($id);
        if (is_null($client)) {
            $response = false;
        } else {
            $response = [
                'companyName' => $client->getCompanyName(),
                'inn' => $client->getInn(),
                'address' => $client->getAddress(),
                'email' => $client->getEmail(),
                'tel' => $client->getTel(),
            ];
        }
        
        return $this->json($response);
    }
    
}