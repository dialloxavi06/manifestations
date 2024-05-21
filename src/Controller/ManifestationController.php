<?php

namespace App\Controller;

use App\Entity\Manifestation;
use App\Entity\Status;
use App\Form\ManifestationType;
use App\Repository\ManifestationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\AnnulationType;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Http\Attribute\IsGranted;



#[Route('/manifestation', name: 'app_manifestation_')]
#[
    IsGranted('ROLE_USER', statusCode: 403, message: 'Vous n\'êtes pas autorisé à accéder à cette page.'),
]
class ManifestationController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET', 'POST'])]
    public function index(ManifestationRepository $manifestationRepository, Request $request): Response
    {
        $page = $request->query->get('page', 1);
        $limit = 3;
        $manifestations = $manifestationRepository->paginateManifestations($page, $limit);
        $totalPages = ceil($manifestations->getTotalItemCount() / $limit);
        return $this->render('manifestation/index.html.twig', [
            'manifestations' => $manifestations,
            'totalItems' => $totalPages,
            'page' => $page,
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response {
        $manifestation = new Manifestation();

        $defaultStatus = $entityManager->getRepository(Status::class)->findOneBy(['nom' => 'En cours d\'évaluation']);
        $form = $this->createForm(ManifestationType::class, $manifestation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manifestation->addStatus($defaultStatus);
            $manifestation->setDuree($manifestation->calculateDuration());
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
        if ($this->isCsrfTokenValid('delete' . $manifestation->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($manifestation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_manifestation_index', [], Response::HTTP_SEE_OTHER);
    }
}
