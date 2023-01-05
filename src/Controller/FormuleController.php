<?php

namespace App\Controller;

use App\Entity\Abonnement;
use App\Entity\Camera;
use App\Entity\Niveau;
use App\Entity\ReglementAbonnement;
use App\Entity\Site;
use App\Repository\AbonnementRepository;
use App\Repository\ClientRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\FormuleRepository;
use App\Repository\NiveauRepository;
use App\Repository\ReferentRepository;
use App\Repository\ReglementAbonnementRepository;
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
    private ReglementAbonnementRepository $reglementAbonnementRepository;
    private ClientRepository $clientRepository;
    private ReferentRepository $referentRepository;
    private EntrepriseRepository $entrepriseRepository;
    private NiveauRepository $niveauRepository;
    public function __construct (
        FormuleRepository $formuleRipo,
        UserRepository $userRepository,
        FormuleRepository $formuleRepository,
        EntityManagerInterface $manager,
        AbonnementRepository $abonnementRepository,
        ReglementAbonnementRepository $reglementAbonnementRepository,
        ClientRepository $clientRepository,
        ReferentRepository $referentRepository,
        EntrepriseRepository $entrepriseRepository,
        NiveauRepository $niveauRepository,
    ){
        $this->formuleRipo = $formuleRipo;
        $this->userRepository = $userRepository;
        $this->formuleRepository = $formuleRepository;
        $this->manager = $manager;
        $this->abonnementRepository=$abonnementRepository;
        $this->reglementAbonnementRepository = $reglementAbonnementRepository;
        $this->clientRepository = $clientRepository;
        $this->referentRepository = $referentRepository;
        $this->entrepriseRepository = $entrepriseRepository;
        $this->niveauRepository = $niveauRepository;
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
                // mise validation de la demainde -> statut-- attente de payement
                $abonnement->setEtatAbonnement($data->get('etat'));

                //creation des sites si il y'a validation
                if ($data->get('etat')=="ATTENTE DE PAYEMENT"){
                    $site = (new Site())
                        ->setSlug(uniqid('site-'))
                        ->setAbonnement($abonnement)
                        ->setLibelle("Site de ".$abonnement->getUser()->getNom())
                        ->setLocalisation($abonnement->getUser()->getAdresse());
                    $abonnement->setSite($site);
                    $this->manager->persist($site);

                    //création de niveaux en fonction du nombre
                    for ($i=0; $i<$abonnement->getNbrNiveau(); $i++){
                        $niveau = (new Niveau())
                            ->setLibelle('Niveau R+'.strval($i))
                            ->setSlug(uniqid('niveau-'))
                            ->setSite($site);
                        $this->manager->persist($niveau);
                    };
                }
            }

            /*
            if ($data->get('etat-frais')){
                $abonnement->setEtatAbonnement($data->get('etat-frais'));
            }
            */

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
        $data = $request->request;
        $abonnement = $this->abonnementRepository->find($data->get('abonnement-id'));

        $reglement = (new ReglementAbonnement())
        ->setPaidAt(new \DateTime())
        ->setAbonnement($abonnement)
            ->setStartAt(date_create($data->get('start-at')))
            ->setEndAt(date_create($data->get('end-at')))
        ->setType($data->get('type'));

        if ($data->get('type')=="ONLINE"){
            $reglement->setIsValide(true);

            if ($data->get('montant') == $abonnement->getPrix() + $abonnement->getFrais() ){
                $abonnement->setEtatFrais(true);
                $this->manager->persist($abonnement);
            }
            if ($abonnement->isEtatFrais()){
                $abonnement->setEtatAbonnement("VALIDE");
            }

        } else {
            $reglement->setIsValide(false);
        }

        $this->manager->persist($reglement);
        $this->manager->flush();
        return $this->json($reglement);
    }

    #[Route('/abonnement/reglement/declarations/update', name: 'formule_abonnement_reglement_update', methods: 'POST')]
    public function updateReglement(Request $request): JsonResponse
    {
        $data = $request->request;
        $reglement = $this->reglementAbonnementRepository->find($data->get('reglement-id'));
        if ($data->get('type')=="VALIDATION-PAYEMENT"){
            $reglement->setIsValide(true);
            $reglement->getAbonnement()->setEtatAbonnement("VALIDE");
            if ($data->get('montant')==$reglement->getAbonnement()->getFrais() + $reglement->getAbonnement()->getPrix()){
                $reglement->getAbonnement()->setEtatFrais(true);
            }
        }
        $this->manager->persist($reglement);
        $this->manager->flush();
        return $this->json($reglement);
    }

    #[Route('/abonnement/list', name: 'app_abonnement')]
    public function listAbonnement(Request $request): JsonResponse
    {
        $data = $request->request;
        //$reglements = $this->reglementAbonnementRepository->findBy(['abonnement'=>$this->abonnementRepository->findOneBy(['user'=>$this->clientRepository->findOneBy(['referent'=>$this->referentRepository->findOneBy(['entreprise'])])])])
        $referent = null;
        if ($data->get('referent-id')!=null){
            $referent = $this->referentRepository->find($data->get('referent-id'));
        }
        $table=[];
        $clients = $this->clientRepository->findBy(['referent'=>$referent]);
        foreach ($clients as $client){
            foreach ($client->getAbonnements() as $abonnement){
                if ($abonnement->getEtatAbonnement()=="ATTENTE DE VALIDATION"){
                    $table[]=
                        [
                        'id'=>$abonnement->getId(),
                        'user'=>$abonnement->getUser(),
                        'formule'=>$abonnement->getFormule(),
                        'etatAbonnement'=>$abonnement->getEtatAbonnement(),
                        'prix'=>$abonnement->getPrix(),
                        'frais'=>$abonnement->getFrais(),
                        'etatFrais'=>$abonnement->isEtatFrais(),
                        'nbrNiveau'=>$abonnement->getNbrNiveau(),
                        'nmrCamera'=>$abonnement->getNbrCamera(),
                        'slug'=>$abonnement->getSlug()
                    ];
                }
            }
        }
        return $this->json($table);
    }

    #[Route('/abonnement/reglement/declarations', name: 'app_abonnement')]
    public function listDeclarationPayement(Request $request): JsonResponse
    {
        $data = $request->request;
        $referent = null;
        if ($data->get('referent-id')!=null){
            $referent = $this->referentRepository->find($data->get('referent-id'));
        }
        $table=[];
        $clients = $this->clientRepository->findBy(['referent'=>$referent]);
        foreach ($clients as $client){
            foreach ($client->getAbonnements() as $abonnement){
                foreach ($abonnement->getReglementAbonnements() as $reglementAbonnement){
                    if ($reglementAbonnement->getType()=="PHYSIQUE" and !$reglementAbonnement->isIsValide()){
                        $table[]=[
                            'id'=>$reglementAbonnement->getId(),
                            'abonnement'=>$reglementAbonnement->getAbonnement(),
                            'paidAt'=>$reglementAbonnement->getPaidAt(),
                            'startAt'=>$reglementAbonnement->getStartAt(),
                            'endAt'=>$reglementAbonnement->getEndAt(),
                            'type'=>$reglementAbonnement->getType()
                        ];
                    }
                }
            }
        }
        return $this->json($table);
    }

    #[Route('/abonnement/camera/add', name: 'add_camera', methods: 'POST')]
    public function addCamera(Request $request): JsonResponse
    {
        $data = $request->request;
        try {
            $niveau = $this->niveauRepository->find($data->get('niveau-id'));
            $site = $niveau->getSite();
            $cpt = 0;
            foreach ($site->getNiveaux() as $niveau){
                if (count($niveau->getCameras())>0){
                    $cpt+=count($niveau->getCameras());
                }
            }
            if ($site->getAbonnement()->getNbrCamera()  < $cpt) {
                $cam = (new Camera())
                    ->setSlug(uniqid('cam-'))
                    ->setLibelle($data->get('libelle'))
                    ->setLogin($data->get('login'))
                    ->setPassword($data->get('password'))
                    ->setIp($data->get('ip'));
                $this->manager->persist($cam);
                $this->manager->flush();
                return $this->json($cam);
            }

            return $this->json('Nombre maximal de camera atteint');
        } catch (\Exception $exception){
            return $this->json($exception);
        }

    }

    #[Route('/abonnement/show/{userId}', name: 'show-abonnement', methods: 'GET')]
    public function index($userId): JsonResponse
    {
        return $this->json($this->abonnementRepository->findBy(['user'=>$userId]));
    }

}
