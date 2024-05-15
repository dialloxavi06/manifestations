<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\AdresseType;


class AdresseController extends AbstractController
{
    #[Route('/adresse/new', name: 'app_adresse_new')]
    public function new(): Response
    {
        $form = $this->createForm(AdresseType::class);
        $form->handleRequest();

        return $this->render('adresse/_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
