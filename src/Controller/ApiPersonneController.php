<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Repository\PersonneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/api/perso/personne')]
class ApiPersonneController extends AbstractController
{
/*
    #[Route('', name: 'app_api_personne')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ApiPersonneController.php',
        ]);
    }

    #[Route('/add', name: 'add_personne', methods:'POST')]
    public function addPersonne(Request $request, EntityManagerInterface $manager): JsonResponse
    {

        $data = $request->request;
        $personne = new Personne();
        $personne->setNom($data->get('nom'));
        $personne->setPrenom($data->get('prenom'));
        $personne->setAge($data->get('age'));

        $manager->persist($personne);
        $manager->flush();

        return $this->json([
            'message' => 'insertion effectuée',
        ]);
    }

    #[Route('/all', name: 'list_personne', methods:'GET')]
    public function listPersonne(PersonneRepository $ripo)
    {
        $personnes = $ripo->findAll();
        $table = [];
        foreach ($personnes as $p) {
           $table[]=[
            'id'=>$p->getId(),
            'nom'=>$p->getNom(),
            'prenom'=>$p->getPrenom(),
            'age'=>$p->getAge()
           ];
        }

        return $this->json($table);
    }
*/

}
