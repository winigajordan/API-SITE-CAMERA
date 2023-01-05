<?php

namespace App\Controller;

use App\Entity\AbonnementPackage;
use App\Entity\ReglementPackage;
use App\Repository\AbonnementPackageRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\PackageRepository;
use App\Repository\ReglementPackageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/api/perso/packages')]
class PackageController extends AbstractController
{
    private PackageRepository $packageRepository;
    private EntrepriseRepository $entrepriseRepository;
    private EntityManagerInterface $manager;
    private AbonnementPackageRepository $abonnementPackageRepository;
    private ReglementPackageRepository $reglementPackageRepository;
    public function __construct (
        PackageRepository $packageRepository,
        EntrepriseRepository $entrepriseRepository,
        EntityManagerInterface $manager,
        AbonnementPackageRepository $abonnementPackageRepository,
        ReglementPackageRepository $reglementPackageRepository,
    ){
        $this->packageRepository = $packageRepository;
        $this->entrepriseRepository = $entrepriseRepository;
        $this->manager = $manager;
        $this->abonnementPackageRepository = $abonnementPackageRepository;
        $this->reglementPackageRepository = $reglementPackageRepository;
    }
    #[Route('/', name: 'app_package', methods: 'GET')]
    public function index(): JsonResponse
    {
        $table = [];
        $packages = $this->packageRepository->findBy(['etat'=>true]);
        foreach ($packages as $package){
            $table[]=[
                'id'=>$package->getId(),
                'libelle'=>$package->getLibelle(),
                'details'=>$package->getDetails(),
                'prix'=>$package->getPrix()
            ];
        }
        return $this->json($table);
    }

    #[Route('/abonnement', name: 'abonnement_package_add', methods: 'POST')]
    public function abonnementPackage(Request $request): JsonResponse
    {
        //return $this->json($request->request);
        try {
            $data = $request->request;
            $package =  $this->packageRepository->find($data->get('package-id'));
            $entreprise = $this->entrepriseRepository->find($data->get('entreprise-id'));
            $abonnement = (new AbonnementPackage())
            ->setEtat('DEMANDE')
            ->setEntreprise($entreprise)
            ->setPackage($package);
            $this->manager->persist($abonnement);
            $this->manager->flush();
            return $this->json($abonnement);
        }catch (\Exception $ex){
            return $this->json($ex);
        }
    }

    #[Route('/abonnement/update', name: 'abonnement_update')]
    public function abonnementPaid(Request $request): JsonResponse
    {
        $data = $request->request;
        $abonnementPackage = $this->abonnementPackageRepository->find($data->get('abonnement-id'));
        $abonnementPackage->setEtat($data->get('etat'));
        $this->manager->persist($abonnementPackage);
        $this->manager->flush();
        return $this->json($abonnementPackage);
    }

    #[Route('/abonnement/reglement/add', name: 'abonnement_reglement_add')]
    public function createReglement(Request $request): JsonResponse
    {
        $data = $request->request;
        $abonnement = $this->abonnementPackageRepository->find($data->get('abonnement-id'));
        $reglement = (new ReglementPackage())
            ->setAbonnement($abonnement)
            ->setPaidAt(new \DateTime())
            ->setStartAt(date_create($data->get('start-at')))
            ->setEndAt(date_create($data->get('end-at')))
        ;
        $abonnement->setEtat('PAYE');
        $this->manager->persist($reglement);
        $this->manager->persist($abonnement);
        $this->manager->flush();
        return $this->json($reglement);
    }

    #[Route('/abonnement/reglement/{id}', name: 'abonnement_reglement_list')]
    public function showEntreprise($id): JsonResponse
    {
        $abonnement = $this->abonnementPackageRepository->find($id);
        $reglements = $this->reglementPackageRepository->findBy(['abonnement'=>$abonnement]);
        $table = [];
        foreach ($reglements as $reglement){
            $table[]=[
                'id'=>$reglement->getId(),
                'abonnement'=>$reglement->getAbonnement(),
                'paidAt'=>$reglement->getPaidAt(),
                'startAt'=>$reglement->getStartAt(),
                'endAt'=>$reglement->getEndAt()
            ];
        }
        return $this->json($table);
    }


}
