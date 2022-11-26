<?php

namespace App\Controller;

use App\Repository\FormuleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/api/perso/formules')]
class FormuleController extends AbstractController
{
    private FormuleRepository $formuleRipo;

    public function __construct (
        FormuleRepository $formuleRipo,
    ){
        $this->formuleRipo = $formuleRipo;
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
}
