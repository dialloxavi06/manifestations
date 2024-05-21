<?php

namespace App\Controller;

use App\Repository\CommuneRepository;
use App\Repository\DepartementRepository;
use App\Repository\ApiRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;


class ApiController extends AbstractController
{
    #[Route('/api/villes/{paysId}', name: 'api_villes', methods: ['GET'])]
    public function index(ApiRepository $villeRepository, $paysId): Response
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


    #[Route('/api/regions/{regionId}/departements', name: 'api_departements_by_region', methods: ['GET'])]
    public function getDepartementsByRegion(int $regionId, DepartementRepository $repository): JsonResponse
    {
        // Utilisez votre repository pour récupérer les départements par région
        $departements = $repository->findDepartementByRegion($regionId);

        // Créez un tableau pour stocker les données des départements avec l'ID de la région inclus
        $departementsArray = [];
        foreach ($departements as $departement) {
            $departementsArray[] = [
                'id' => $departement->getId(),
                'nom' => $departement->getNom(),
                'code' => $departement->getCode(),
                'region_id' => $departement->getRegion()->getId() // Ajoutez l'ID de la région correspondante
            ];
        }

        // Renvoyez la réponse JSON avec l'ID de la région inclus
        return $this->json($departementsArray, 200, [], ['groups' => 'departement:read']);
    }

    #[Route('/api/departements/{departementId}/villes', name: 'api_villes_by_departement', methods: ['GET'])]

    public function getVillesByDepartement(int $departementId, CommuneRepository $repository): JsonResponse
    {
        // Utilisez votre repository pour récupérer les villes par département
        $villes = $repository->findCommuneByDepartement($departementId);

        // Créez un tableau pour stocker les données des villes avec l'ID du département inclus
        $villesArray = [];
        foreach ($villes as $ville) {
            $villesArray[] = [
                'id' => $ville->getId(),
                'nom' => $ville->getNom(),
                'code' => $ville->getCode(),
                'departement_id' => $ville->getDepartement()->getId() // Ajoutez l'ID du département correspondant
            ];
        }


        // Renvoyez la réponse JSON avec l'ID du département inclus
        return $this->json($villesArray, 200, [], ['groups' => 'ville:read']);
    }
    //
}
