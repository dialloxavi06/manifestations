<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\KontaktType;
use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;


class KontaktController extends AbstractController
{
    #[Route('/kontakt', name: 'app_kontakt')]
    public function index(): Response
    {
        return $this->render('kontakt/index.html.twig', [
            'controller_name' => 'KontaktController',
        ]);
    }
}
