<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Repository\EntrepriseRepository;
use App\Repository\ReferentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/api/perso/entreprise')]
class EntrepriseController extends AbstractController
{

    private ReferentRepository $referentRepository;
    private EntityManagerInterface $manager;
    private EntrepriseRepository $entrepriseRepository;
    public function __construct(
        ReferentRepository $referentRepository,
        EntityManagerInterface $manager,
        EntrepriseRepository $entrepriseRepository,
    )
    {
        $this->referentRepository=$referentRepository;
        $this->manager = $manager;
        $this->entrepriseRepository=$entrepriseRepository;
    }

    #[Route('/add', name: 'add_entreprise', methods: 'POST')]
    public function addEntreprise(Request $request): JsonResponse
    {
        try {
            $data = $request->request;
            $entreprise = (new Entreprise())
                ->setReferent($this->referentRepository->find($data->get('referent_id')))
                ->setSlug(uniqid('etreprise-'))
                ->setLibelle($data->get('libelle'))
                ->setNinea($data->get('ninea'))
                ->setRccm($data->get('rccm'));
            
            $this->manager->persist($entreprise);
            $this->manager->flush();
            return $this->json($entreprise, 200);
        } catch (\Exception $exception) {
            return $this->json($exception, 500);
        }
    }

    #[Route('/show/{id}', name: 'entreprise_show')]
    public function showEntreprise($id): JsonResponse
    {
        return $this->json($this->entrepriseRepository->find($id));
    }

    #[Route('/update', name: 'entreprise_update')]
    public function updateEntreprise(Request $request): JsonResponse
    {
        $data=$request->request;
        $entreprise = $this->entrepriseRepository->find($data->get('id'));
        $entreprise->setLibelle($data->get('libelle'));
        $entreprise->setRccm($data->get('rccm'));
        $entreprise->setNinea($data->get('ninea'));
        $this->manager->persist($entreprise);
        $this->manager->flush();
        return $this->json($entreprise);
    }


}
