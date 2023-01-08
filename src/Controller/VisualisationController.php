<?php

namespace App\Controller;

use App\Repository\AbonnementRepository;
use App\Repository\CameraRepository;
use App\Repository\NiveauRepository;
use App\Repository\SiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/perso/visualisation')]
class VisualisationController extends AbstractController
{
    private AbonnementRepository $abonnementRepository;
    private SiteRepository $siteRepository;
    private NiveauRepository $niveauRepository;
    private CameraRepository $cameraRepository;

    public function __construct(
        AbonnementRepository $abonnementRepository,
        SiteRepository $siteRepository,
        NiveauRepository $niveauRepository,
        CameraRepository $cameraRepository
    )
    {
        $this->abonnementRepository = $abonnementRepository;
        $this->siteRepository = $siteRepository;
        $this->niveauRepository = $niveauRepository;
        $this->cameraRepository = $cameraRepository;
    }

    #[Route('/site/{abonnementId}', name: 'app_visualisation_site', methods: 'GET')]
    public function getSite($abonnementId): JsonResponse
    {
        return $this->json($this->abonnementRepository->find($abonnementId)->getSite());
    }

    #[Route('/niveaux/{siteId}', name: 'app_visualisation_niveau',methods: 'GET')]
    public function getNiveaux($siteId): JsonResponse
    {
        return $this->json($this->siteRepository->find($siteId)->getNiveaux());
    }

    #[Route('/camera/{niveauId}', name: 'app_visualisation_camera', methods: 'GET')]
    public function getCameras($niveauId): JsonResponse
    {
        return $this->json($this->niveauRepository->find($niveauId)->getCameras());
    }

    #[Route('/camera/show/{id}', name: 'app_visualisation_camera_show', methods: 'GET')]
    public function showCamera($id): JsonResponse
    {
        return $this->json($this->cameraRepository->find($id));
    }
/*
    #[Route('/camera/enregistrement', name: 'app_visualisation_enregistrement_', methods: 'POST')]
    public function show(Request $request): JsonResponse
    {
        $data = $request->request;

        return $this->json();
    }
*/
}
