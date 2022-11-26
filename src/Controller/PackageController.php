<?php

namespace App\Controller;

use App\Repository\PackageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/api/perso/packages')]
class PackageController extends AbstractController
{
    private PackageRepository $packageRepository;

    public function __construct (
        PackageRepository $packageRepository,
    ){
        $this->packageRepository = $packageRepository;
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
}
