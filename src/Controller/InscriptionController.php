<?php

namespace App\Controller;

use App\Entity\Abonnement;
use Exception;
use App\Entity\Client;
use App\Entity\Inscription;
use Doctrine\ORM\Query\Expr\Func;
use App\Entity\AbonnementInscription;
use App\Repository\FormuleRepository;
use App\Repository\EntrepriseRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\InscriptionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\AbonnementInscriptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api/perso/inscriptions')]
class InscriptionController extends AbstractController
{
    private EntityManagerInterface $manager;
    private FormuleRepository $formuleRepository;
    private AbonnementInscriptionRepository $abonnementInscription;
    private EntrepriseRepository $entrepriseRepository;
    private InscriptionRepository $inscriptionRepository;
    public function __construct(
        EntityManagerInterface $manager,
        FormuleRepository $formuleRepository,
        AbonnementInscriptionRepository $abonnementInscription,
        EntrepriseRepository $entrepriseRepository,
        InscriptionRepository $inscriptionRepository
    )
    {
        $this->manager = $manager;
        $this->abonnementInscription=$abonnementInscription;
        $this->formuleRepository = $formuleRepository;
        $this->entrepriseRepository = $entrepriseRepository;
        $this->inscriptionRepository = $inscriptionRepository;

    }

    #[Route('', name: 'app_inscription', methods: 'POST')]
    public function addInscription(Request $request): JsonResponse
    {
        try {
            $data = $request->request;
            $inscription = (new Inscription())
                ->setEtatInscription(false)
                ->setNom($data->get('nom'))
                ->setPrenom($data->get('prenom'))
                ->setMail($data->get('mail'))
                ->setLogin($data->get('login'))
                ->setPassword($data->get('password'))
                ->setTelephone($data->get('telephone'))
                ->setRegion($data->get('region'))
                ->setPays($data->get('pays'))
                ->setAdresse($data->get('adresse'))
                ->setAbonnementInscription($this->abonnementInscription->find($data->get('abonnementInsciption')));
                if ($data->get('entreprise_id')!=0) {
                    $inscription->setEntreprise($this->entrepriseRepository->find($data->get('entreprise_id')));
                }
            
            $this->manager->persist($inscription);
            $this->manager->flush();
            return $this->json($inscription, 200);
        } catch (\Exception $exception) {
            return $this->json($exception, 500);
        }

    }

    #[Route('/abonnements', name: 'add_inscription', methods: 'POST')]
    public function addAbonnementInscription(Request $request): JsonResponse
    {
        try {
            $data = $request->request;
            $abonnement = (new AbonnementInscription())
                ->setPrix($data->get('prix'))
                ->setFrais($data->get('frais'))
                ->setNbrNiveau($data->get('nbrNiveau'))
                ->setNbrCamera($data->get('nbrCamera'))
                ->setFormule($this->formuleRepository->find($data->get('formule_id')));
            $this->manager->persist($abonnement);
            $this->manager->flush();
            return $this->json($abonnement);
        } catch (\Exception $exception){
            return $this->json($exception, 500);
        }
    }

    #[Route('/list/{entreprise_id}', name:'get_inscriptions', methods: 'GET', defaults:['entreprise_id'=>0])]
    public function getInscriptions($entreprise_id): JsonResponse
    {
        //return $this->json($entreprise_id);
        $inscriptions = $this->inscriptionRepository->findBy(['entreprise'=>$this->entrepriseRepository->find($entreprise_id), 'etatInscription'=>false]);
        $table = [];
        foreach($inscriptions as $inscription){
            $table[] = [
                'id'=>$inscription->getId(),
                'nom'=>$inscription->getNom(),
                'prenom'=>$inscription->getPrenom(),
                'mail'=>$inscription->getMail(),
                'login'=>$inscription->getLogin(),
                'password'=>$inscription->getPassword(),
                'telephone'=>$inscription->getTelephone(),
                'region'=>$inscription->getRegion(),
                'pays'=>$inscription->getPays(),
                'abonnementInscriptionId'=>$inscription->getAbonnementInscription()->getId(),
                'entrepriseId'=>$inscription->getEntreprise(),
            ];
        }
        return $this->json($table);
    }

    #[Route('/abonnement/{id}', name:'get_abonnement_inscription', methods:'GET')]
    public function getAbonnementInscription($id) : JsonResponse
    {
        try {
            $abonnement = $this->abonnementInscription->find($id);
            return $this->json($abonnement, 200);
        }
        catch (\Exception $exception){
            return $this->json($exception, 500);
        }
    }

    #[Route('/validation', methods: 'POST')]
    public function validation(Request $request) : JsonResponse
    {
        $inscription = $this->inscriptionRepository->find($request->request->get('inscription_id'));
        if ($request->request->get('validation')!=0){

            $client = new Client();
            $client ->setNom($inscription->getNom())
            ->setPrenom($inscription->getPrenom())
                ->setPays($inscription->getPrenom())
                ->setMail($inscription->getMail())
                ->setLogin($inscription->getLogin())
                ->setPassword($inscription->getPassword())
                ->setTelephone($inscription->getTelephone())
                ->setRegion($inscription->getRegion())
                ->setPays($inscription->getPays())
                ->setAdresse($inscription->getAdresse());
            
            if ($inscription->getEntreprise()!=null) {
                    $client->setReferent($inscription->getEntreprise()->getReferent());
            }
            
            $this->manager->persist($client);

            $abonnementInscription = $inscription->getAbonnementInscription();
            $abonnement = new Abonnement();
            $abonnement->setPrix($abonnementInscription->getPrix())
            ->setFrais($abonnementInscription->getFrais())
            ->setNbrNiveau($abonnementInscription->getNbrNiveau())
            ->setNbrCamera($abonnementInscription->getNbrCamera())
            ->setFormule($abonnementInscription->getFormule())
            ->setUser($client)
            ->setEtatAbonnement("ATTENTE DE PAYEMENT")
            ->setEtatFrais(false)
            ->setSlug(uniqid('abnm-'));
            $this->manager->persist($abonnement);
        }
        
        $inscription->setEtatInscription(true);
        $this->manager->persist($inscription);
        $this->manager->flush();

        return $this->json($abonnement);
    }

    
    
} 
