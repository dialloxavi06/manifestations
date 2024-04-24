<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Discipline;
use App\Form\DisciplineType;
use App\Repository\DisciplineRepository;

class DisciplineController extends AbstractController
{
    #[Route('/discipline', name: 'app_discipline')]
    public function index(DisciplineRepository $repository): Response
    {

        $disciplines = $repository->findAll();

        return $this->render('discipline/index.html.twig', [
            'disciplines' => $disciplines,
        ]);
    }

    #[Route('/discipline/new', name: 'app_discipline_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $discipline = new Discipline();
        $form = $this->createForm(DisciplineType::class, $discipline);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($discipline);
            $em->flush();

            return $this->redirectToRoute('app_discipline', [], Response::HTTP_SEE_OTHER);
        }


        return $this->render('discipline/new.html.twig', [
            'discipline' => $discipline,
            'form' => $form->createView(),
        ]);
    }
}
