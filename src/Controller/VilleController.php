<?php

namespace App\Controller;

use App\Repository\VilleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VilleController extends AbstractController
{
    #[Route('/api/villes/{paysId}', name: 'api_villes', methods: ['GET'])]
    public function index(VilleRepository $villeRepository, $paysId): Response
    {
        // Utilisez le paramètre $paysId pour filtrer les villes
        $villes = $villeRepository->findBy(['countries' => $paysId]);

        // Parcourir chaque ville et ajouter l'ID du pays à la réponse JSON
        $villesArray = [];
        foreach ($villes as $ville) {
            $villesArray[] = [
                'id' => $ville->getId(),
                'nom' => $ville->getNom(),
                'code' => $ville->getCode(),
                'pays_id' => $ville->getCountries()->getId() // Ajoutez l'ID du pays correspondant
            ];
        }


        // Renvoyer la réponse JSON avec l'ID du pays inclus
        return $this->json($villesArray, 200, [], ['groups' => 'ville:read']);
    }
}
