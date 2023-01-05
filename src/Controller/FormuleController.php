<?php

namespace App\Controller;

use App\Entity\Abonnement;
use App\Repository\AbonnementRepository;
use App\Repository\FormuleRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Yaml\Exception\ExceptionInterface;

#[Route('/api/perso/formules')]
class FormuleController extends AbstractController
{
    private FormuleRepository $formuleRipo;
    private UserRepository $userRepository;
    private FormuleRepository $formuleRepository;
    private EntityManagerInterface $manager;
    private AbonnementRepository $abonnementRepository;
    public function __construct (
        FormuleRepository $formuleRipo,
        UserRepository $userRepository,
        FormuleRepository $formuleRepository,
        EntityManagerInterface $manager,
        AbonnementRepository $abonnementRepository,
    ){
        $this->formuleRipo = $formuleRipo;
        $this->userRepository = $userRepository;
        $this->formuleRepository = $formuleRepository;
        $this->manager = $manager;
        $this->abonnementRepository;
    }


    #[Route('/', name: 'app_formule', methods:'GET')]
    public function formulesActives(): JsonResponse
    {
        $formule = $this->formuleRipo->findBy(['etat'=>true]);
        $table = [];
        foreach ($formule as $f) {
            $table[]=[
             'id'=>$f->getId(),
             'libelle'=>$f->getLibelle(),
             'prix1'=>$f->getPrix1(),
             'prix2'=>$f->getPrix2(),
             'etat'=>$f->isEtat()
            ];
         }
        return $this->json($table);
    }

    #[Route('/abonnement', name: 'app_formule_abonnement', methods: 'POST')]
    public function createAbonnement(Request $request): JsonResponse
    {
        try {
            $data = $request->request;
            $abonnement = (new Abonnement())
                ->setEtatAbonnement('ATTENTE DE VALIDATION')
                ->setPrix($data->get('prix'))
                ->setFrais($data->get('frais'))
                ->setSlug(uniqid('abnmnt-'))
                ->setEtatFrais(false)
                ->setNbrNiveau($data->get('nombre-niveau'))
                ->setNbrCamera($data->get('nombre-camera'));
            $user = $this->userRepository->find($data->get('user-id'));
            $formule = $this->formuleRepository->find($data->get('formule-id'));
            $abonnement->setUser($user);
            $abonnement->setFormule($formule);
            $this->manager->persist($abonnement);
            $this->manager->flush();
            return $this->json($abonnement);
        } catch (\Exception $exception){
            return $this->json($exception);
        }
    }

    #[Route('/abonnement/update', name: 'app_formule_abonnement_update')]
    public function update(Request $request): JsonResponse
    {
        $data = $request->request;
        try {
            $abonnement = $this->abonnementRepository->find($data->get('abonnement-id'));
            if ($data->get('etat')){
                $abonnement->setEtatAbonnement($data->get('etat'));
            }
            if ($data->get('etat-frais')){
                $abonnement->setEtatAbonnement($data->get('etat-frais'));
            }

            $this->manager->persist($abonnement);
            $this->manager->flush();

            return $this->json($abonnement);
        }catch (\Exception $exception){
            return $this->json($exception);
        }

    }

    #[Route('/abonnement/reglement', name: 'app_formule_abonnement_reglement')]
    public function reglementAbonnement(Request $request): JsonResponse
    {

        return $this->json();
    }
}
