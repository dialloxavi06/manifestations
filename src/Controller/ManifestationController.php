<?php

namespace App\Controller;

use App\Entity\Manifestation;
use App\Form\ManifestationType;
use App\Repository\ManifestationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/', name: 'app_manifestation_')]
class ManifestationController extends AbstractController
{
    #[Route('manifestation', name: 'index', methods: ['GET', 'POST'])]
    public function index(ManifestationRepository $manifestationRepository): Response
    {

        return $this->render('manifestation/index.html.twig', [
            'manifestations' => $manifestationRepository->findAll(),
        ]); 
    } 

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $manifestation = new Manifestation();
        $form = $this->createForm(ManifestationType::class, $manifestation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {  
            $entityManager->persist($manifestation);
            $entityManager->flush();

            return $this->redirectToRoute('app_manifestation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('manifestation/new.html.twig', [
            'manifestation' => $manifestation,
            'form' => $form,
        ]);
    } 

    #[Route('{id}/show', name: 'show', methods: ['GET', 'POST'])]
    public function show(Manifestation $manifestation): Response
    {
        return $this->render('manifestation/show.html.twig', [
            'manifestation' => $manifestation,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Manifestation $manifestation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ManifestationType::class, $manifestation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_manifestation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('manifestation/edit.html.twig', [
            'manifestation' => $manifestation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Manifestation $manifestation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$manifestation->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($manifestation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_manifestation_index', [], Response::HTTP_SEE_OTHER);
    }
}
