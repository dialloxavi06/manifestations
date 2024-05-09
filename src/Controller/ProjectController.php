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

#[Route('/project', name: 'app_project_')]
#[IsGranted('ROLE_USER')]
class ProjectController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET', 'POST'])]
    public function index(ProjectRepository $projectRepository): Response
    {
        $projects = $projectRepository->findAll();
        return $this->render('project/index.html.twig', [
            'projects' => $projects,
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
}
