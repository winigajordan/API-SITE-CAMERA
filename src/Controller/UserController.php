<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Referent;
use App\Entity\User;
use App\Repository\ClientRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\ReferentRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/perso/user')]
class UserController extends AbstractController
{
    private ReferentRepository $referentRepository;
    private EntityManagerInterface $manager;
    private UserRepository $userRepository;
    private ClientRepository $clientRepository;
    private EntrepriseRepository $entrepriseRepository;
    public function __construct(
        ReferentRepository $referentRepository,
        EntityManagerInterface $manager,
        UserRepository $userRepository,
        EntrepriseRepository $entrepriseRepository,
        ClientRepository $clientRepository,
    )
    {
        $this->referentRepository=$referentRepository;
        $this->manager = $manager;
        $this->userRepository = $userRepository;
        $this->entrepriseRepository = $entrepriseRepository;
        $this->clientRepository = $clientRepository;
    }

    #[Route('/add/referent', name: 'add_referent', methods: 'POST')]
    public function addReferent(Request $request) : JsonResponse
    {
        $data = $request->request;
        try {
            $ref = (new Referent())
                ->setNom($data->get('nom'))
                ->setPrenom($data->get('prenom'))
                ->setPassword($data->get('password'))
                ->setMail($data->get('mail'))
                ->setLogin($data->get('login'))
                ->setTelephone($data->get('telephone'))
                ->setRegion($data->get('region'))
                ->setPays($data->get('pays'))
                ->setAdresse($data->get('adresse'));

            $this->manager->persist($ref);
            $this->manager->flush();
            $table = [
                'id_insere'=>$ref->getId()
            ];
            return $this->json($table, 200);
        } catch (\Exception $exception) {
            return $this->json($exception, 500);
        }
    }


    #[Route('/add/client', name: 'add_client', methods: 'POST')]
    public function addClient(Request $request): JsonResponse
    {
        $data = $request->request;
        try {
            $client = (new Client())
            ->setNom($data->get('nom'))
            ->setPrenom($data->get('prenom'))
            ->setPassword($data->get('password'))
            ->setMail($data->get('mail'))
            ->setLogin($data->get('login'))
            ->setTelephone($data->get('telephone'))
            ->setRegion($data->get('region'))
            ->setPays($data->get('pays'))
            ->setAdresse($data->get('adresse'));

            if ($data->get('referent-id')) {

                $client->setReferent($this->referentRepository->find($data->get('referent-id')));
            }

            $this->manager->persist($client);
            $this->manager->flush();
            $table = [
                'id_insere'=>$client->getId()
            ];
            return $this->json($table, 200);
        } catch (\Exception $exception) {
            return $this->json($exception, 500);
        }
    }


    #[Route('/login', name: 'login', methods: 'POST')]
    public function login(Request $request): JsonResponse
    {
        $data = $request->request;

        if ($data->get('referent-id')!=null){
            $referent = $this->referentRepository->find($data->get('referent-id'));
            //return $this->json($referent);
            $client = $this->clientRepository->findBy(['login'=>$data->get('login'), 'password'=>$data->get('password'), 'referent'=>$referent]);
            return $this->json($client);
        } else {
            $user = $this->userRepository->findOneBy(['login'=>$data->get('login'), 'password'=>$data->get('password')]);
            return $this->json($user);
        }
    }


    #[Route('/update', name: 'update_account', methods: 'POST')]
    public function update(Request $request): JsonResponse
    {
        try {
            $data = $request->request;
            $user = $this->userRepository->find($data->get('id'));
            $user->setNom($data->get('nom'));
            $user->setPrenom($data->get('prenom'));
            $user->setPassword($data->get('password'));
            $user->setMail($data->get('mail'));
            $user->setLogin($data->get('login'));
            $user->setTelephone($data->get('pays'));
            $user->setRegion($data->get('region'));
            $user->setPays($data->get('pays'));
            $user->setAdresse($data->get('adresse'));
            $this->manager->persist($user);
            $this->manager->flush();
            return $this->json($user);
        } catch (\Exception $exception){
            return $this->json($exception);
        }

    }


}
