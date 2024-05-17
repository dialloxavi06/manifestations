<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Project;
use App\Form\ProjectType;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Status;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Form\AnnulationType;
use App\Form\KontaktType;


#[Route('/project', name: 'app_project_')]
#[
    IsGranted('ROLE_USER', statusCode: 403, message: 'Vous n\'avez pas les droits nécessaires pour accéder à cette page.'),
]
class ProjectController extends AbstractController
{

    #[Route('/', name: 'index', methods: ['GET', 'POST'])]
    public function index(ProjectRepository $projectRepository, Request $request): Response
    {

        $page = $request->query->get('page', 1);
        $limit = 3;
        $projects = $projectRepository->paginateProjects($page, $limit);
        $totalPages = ceil($projects->getTotalItemCount() / $limit);
        // Récupération de l'utilisateur en cours


        return $this->render('project/index.html.twig', [
            'projects' => $projects,
            'page' => $page,
            'totalPages' => $totalPages,
        ]);
    }

    #[Route('/create', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $defaultStatus = $em->getRepository(Status::class)->findOneBy(['nom' => 'En cours d\'évaluation']);
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $project->setStatusProject($defaultStatus);
            $em->persist($project);
            $em->flush();
            $this->addFlash('success', 'Le projet a bien été créé');
            return $this->redirectToRoute('app_project_index');
        }

        return $this->render('project/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/edit/{id}', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Project $project, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Le projet a bien été modifié');
            return $this->redirectToRoute('app_project_index');
        }

        return $this->render('project/edit.html.twig', [
            'form' => $form->createView(),
            'project' => $project,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Project $project, EntityManagerInterface $em): Response
    {
        $em->remove($project);
        $em->flush();
        $this->addFlash('success', 'Le projet a bien été supprimé');
        return $this->redirectToRoute('app_project_index');
    }


    #[Route('/show/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id, ProjectRepository $repository): Response
    {
        $project = $repository->find($id);

        return $this->render('project/show.html.twig', [
            'project' => $project
        ]);
    }

    #[Route('/{id}/annulation', name: 'annulation')]
    public function annulation(Request $request, Project $projet, MailerInterface $mailer, EntityManagerInterface $entityManager): Response
    {
        // Charger les valeurs actuelles de la manifestation dans le formulaire d'annulation
        $form = $this->createForm(AnnulationType::class, $projet);
        $form->handleRequest($request);
        $user = $this->getUser();
        // Récupère l'email de l'utilisateur
        $userEmail = $user->getUserIdentifier();


        // Rechercher le statut par défaut
        $defaultStatus = $entityManager->getRepository(Status::class)->findOneBy(['nom' => 'En cours de rétractation']);

        $emailMessage = <<<EOT
                    <!DOCTYPE html>
                    <html lang="fr">
                    <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Annulation de projet</title>
                    </head>
                    <body>
                    <h2 style="color: #333; font-family: Arial, sans-serif;">Demande d'annulation de projet</h2>
                    <p style="font-family: Arial, sans-serif;">Bonjour,</p>
                    <p style="font-family: Arial, sans-serif;">L'utilisateur avec l'adresse email $userEmail souhaite annuler son projet intitulé :</p>
                    <ul style="font-family: Arial, sans-serif; margin-left: 20px;">
                        <li>Titre en français : {$projet->getTitreFr()}</li>
                        <li>Titre en allemand : {$projet->getTitreDe()}</li>
                    </ul>
                    <p style="font-family: Arial, sans-serif;">Motif d'annulation :</p>
                    <h3 style="color: #333; font-family: Arial, sans-serif;">{$projet->getMotifAnnulation()}</h3>
                    <p style="font-family: Arial, sans-serif;">Justification de l'annulation :</p>
                    <p style="font-family: Arial, sans-serif;">{$projet->getJustificationAnnulation()}</p>
                    <p style="font-family: Arial, sans-serif;">Merci de prendre les mesures nécessaires.</p>
                    <p style="font-family: Arial, sans-serif;">Cordialement,</p>
                    <p style="font-family: Arial, sans-serif;">Votre équipe de gestion des projets</p>
                    </body>
                    </html>
           EOT;

        if ($form->isSubmitted() && $form->isValid()) {
            // Supprimer tous les statuts existants de la manifestation
            // Mettre à jour les informations de l'annulation
            $data = $form->getData();
            $projet->setMotifAnnulation($data->getMotifAnnulation());
            $projet->setJustificationAnnulation($data->getJustificationAnnulation());
            $projet->setStatusProject($defaultStatus);

            // Envoyer l'email de confirmation
            try {
                $email = (new Email())
                    ->to('diallo@dfh-ufa.org')
                    ->from($userEmail)
                    ->subject($projet->getMotifAnnulation())
                    ->text($projet->getMotifAnnulation())
                    ->html($emailMessage);
                $mailer->send($email);

                $entityManager->flush();

                $this->addFlash('success', 'Votre message a bien été envoyé. Merci / Ihre Nachricht wurde erfolgreich gesendet. Danke!');
                return $this->redirectToRoute('app_project_index');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Une erreur est survenue. Veuillez réessayer / Es ist ein Fehler aufgetreten. Bitte versuchen Sie es erneut.');
            }
        }

        return $this->render('project/annulation.html.twig', [
            'form' => $form->createView(),
            'project' => $projet,
        ]);
    }

    #[Route('/kontakt/new/{id}', name: 'new_kontakt', methods: ['GET', 'POST'])]
    public function new(Request $request, int $id, EntityManagerInterface $entityManager, ProjectRepository $repository): Response
    {
        $project = $repository->find($id);
        $form = $this->createForm(KontaktType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $kontakt = $form->getData();
            $project->addKontakt($kontakt);

            $entityManager->persist($kontakt);
            $entityManager->flush();

            return $this->redirectToRoute('app_project_index');
        }

        return $this->render('kontakt/new.html.twig', [
            'project' => $project,
            'form' => $form->createView(),
        ]);
    }
}
