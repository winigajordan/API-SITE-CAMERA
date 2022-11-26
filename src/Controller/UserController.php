<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Referent;
use App\Repository\ReferentRepository;
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
    public function __construct(
        ReferentRepository $referentRepository,
        EntityManagerInterface $manager
    )
    {
        $this->referentRepository=$referentRepository;
        $this->manager = $manager;
    }

    #[Route('/add/referent', name: 'add_referent', methods: 'POST')]
    public function addReferent(Request $request) : JsonResponse
    {
        $data = $request->request;
        try {
            $client = (new Referent())
                ->setNom($data->get('nom'))
                ->setPrenom($data->get('prenom'))
                ->setPassword($data->get('password'))
                ->setMail($data->get('mail'))
                ->setLogin($data->get('login'))
                ->setTelephone($data->get('telephone'))
                ->setRegion($data->get('region'))
                ->setPays($data->get('pays'))
                ->setAdresse($data->get('adresse'));

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

            if ($data->get('referent_id')) $client->setReferent($this->referentRepository->find($data->get('referent_id')));
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
}
