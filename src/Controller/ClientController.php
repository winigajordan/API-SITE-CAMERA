<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use App\Repository\ReferentRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/perso/clients')]
class ClientController extends AbstractController
{
   
    private ClientRepository $clientRepository;
    private ReferentRepository $referentRipo;
    private UserRepository $userRepository;
   
    function __construct(
        ClientRepository $clientRepository, 
        ReferentRepository $referentRipo,
        UserRepository $userRepository,
        ) {
    	$this->userRepository = $userRepository;
    	$this->clientRepository = $clientRepository;
    	$this->referentRipo = $referentRipo;
    
    }

    #[Route('/referent/{id}', name: 'clients_referent')]
    public function clientsEntreprise($id): JsonResponse
    {
        $client = $this->referentRipo->find($id)->getClients();
        $table = [];
        foreach ($client as $cl) {
            $table[] = [
                'id'=>$cl->getId(),
                'nom'=>$cl->getNom(),
                'prenom'=>$cl->getPrenom(),
                'mail'=>$cl->getMail(),
                'login'=>$cl->getLogin(),
                'password'=>$cl->getPassword(),
                'telephone'=>$cl->getTelephone(),
                'region'=>$cl->getRegion(),
                'pays'=>$cl->getPays()
            ];
        }
        return $this->json($table);
    }

    #[Route('/digiplanit/{need}', name: 'client_digiplanit')]
    public function clientsDigiplanit($need): JsonResponse
    {
        $table = [];
        if ($need=="REF"){
            $refs =  $this->referentRipo->findAll();
            foreach ($refs as $cl)
            {
                $table[] = [
                    'id'=>$cl->getId(),
                    'nom'=>$cl->getNom(),
                    'prenom'=>$cl->getPrenom(),
                    'mail'=>$cl->getMail(),
                    'login'=>$cl->getLogin(),
                    'password'=>$cl->getPassword(),
                    'telephone'=>$cl->getTelephone(),
                    'region'=>$cl->getRegion(),
                    'pays'=>$cl->getPays(),
                    'entreprise'=>$cl->getEntreprises(),
                    
                ];
            }
        } else 
        {
            $cls =  $this->clientRepository->findBy(['referent'=>null]);
            foreach ($cls as $cl)
            {
                $table[] = [
                    'id'=>$cl->getId(),
                    'nom'=>$cl->getNom(),
                    'prenom'=>$cl->getPrenom(),
                    'mail'=>$cl->getMail(),
                    'login'=>$cl->getLogin(),
                    'password'=>$cl->getPassword(),
                    'telephone'=>$cl->getTelephone(),
                    'region'=>$cl->getRegion(),
                    'pays'=>$cl->getPays(),
                ];
            }
        }      
        return $this->json($table);
    }

    #[Route('/{id}', name: 'client_unique')]
    public function client($id): JsonResponse
    {
        return $this->json($this->userRepository->find($id));
    }
    

    

}
