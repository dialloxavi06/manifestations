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
use App\Entity\Project;



#[Route('/manifestation', name: 'app_manifestation_')]
class ManifestationController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET', 'POST'])]
    public function index(ManifestationRepository $manifestationRepository, Request $request): Response
    {
        $page = $request->query->get('page', 1);
        $limit = 1;
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
        // Ajouter le statut par défaut en utilisant la méthode addStatuses
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

    #[Route('/{id}/annulation', name: 'annulation')]
    public function annulation(Request $request, Manifestation $manifestation, MailerInterface $mailer, EntityManagerInterface $entityManager): Response
    {
        // Charger les valeurs actuelles de la manifestation dans le formulaire d'annulation
        $form = $this->createForm(AnnulationType::class, $manifestation);
        $form->handleRequest($request);

        // Rechercher le statut par défaut
        $defaultStatus = $entityManager->getRepository(Status::class)->findOneBy(['nom' => 'En cours de rétractation']);

        if ($form->isSubmitted() && $form->isValid()) {
            // Supprimer tous les statuts existants de la manifestation
            $manifestation->removeAllStatus();

            // Mettre à jour les informations de l'annulation
            $data = $form->getData();
            $manifestation->setMotifAnnulation($data->getMotifAnnulation());
            $manifestation->setDescriptionAnnulation($data->getDescriptionAnnulation());
            $manifestation->addStatus($defaultStatus);

            // Envoyer l'email de confirmation
            try {
                $email = (new Email())
                    ->to('diallo@dfh-ufa.org')
                    ->from('diallox@gmail.com')
                    ->subject($manifestation->getMotifAnnulation())
                    ->text($manifestation->getMotifAnnulation())
                    ->html('<p>' . $manifestation->getMotifAnnulation() . '</p>');
                $mailer->send($email);

                $entityManager->flush();

                $this->addFlash('success', 'Votre message a bien été envoyé. Merci / Ihre Nachricht wurde erfolgreich gesendet. Danke!');
                return $this->redirectToRoute('app_manifestation_index');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Une erreur est survenue. Veuillez réessayer / Es ist ein Fehler aufgetreten. Bitte versuchen Sie es erneut.');
            }
        }

        return $this->render('manifestation/annulation.html.twig', [
            'form' => $form->createView(),
            'manifestations' => $manifestation,
        ]);
    }
}
