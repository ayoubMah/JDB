<?php

namespace App\Controller;

use App\Entity\Stagiaire;
use App\Form\StagiaireType;
use App\Repository\StagiaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/stagiaire')]
class StagiaireController extends AbstractController
{
    #[Route('/', name: 'app_stagiaire_index', methods: ['GET'])]
    public function index(Request $request, StagiaireRepository $stagiaireRepository): Response
    {
        $searchQuery = $request->query->get('q');
        $stagiaires = $stagiaireRepository->findBySearchQuery($searchQuery);

        return $this->render('stagiaire/index.html.twig', [
            'stagiaires' => $stagiaires,
        ]);
    }

    #[Route('/new', name: 'app_stagiaire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $stagiaire = new Stagiaire();
        $form = $this->createForm(StagiaireType::class, $stagiaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Generate a new random password
            $newPassword = bin2hex(random_bytes(4));
            $hashedPassword = $passwordHasher->hashPassword($stagiaire, $newPassword);

            // Set the hashed password
            $stagiaire->setPassword($hashedPassword);

            $entityManager->persist($stagiaire);
            $entityManager->flush();

            // Optionally, add a flash message with the new password
            $this->addFlash('success', "New Stagiaire created with password: $newPassword");

            return $this->redirectToRoute('app_stagiaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('stagiaire/new.html.twig', [
            'stagiaire' => $stagiaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_stagiaire_show', methods: ['GET'])]
    public function show(Stagiaire $stagiaire): Response
    {
        if(!$stagiaire){
            throw $this->createNotFoundException('The stagiaire does not exist');
        }
        return $this->render('stagiaire/show.html.twig', [
            'stagiaire' => $stagiaire,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_stagiaire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Stagiaire $stagiaire, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $form = $this->createForm(StagiaireType::class, $stagiaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle password update
            $newPassword = $form->get('password')->getData();
            if ($newPassword) {
                $hashedPassword = $passwordHasher->hashPassword($stagiaire, $newPassword);
                $stagiaire->setPassword($hashedPassword);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_stagiaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('stagiaire/edit.html.twig', [
            'stagiaire' => $stagiaire,
            'form' => $form->createView(),
        ]);
    }


    #[Route('/{id}', name: 'app_stagiaire_delete', methods: ['POST'])]
    public function delete(Request $request, Stagiaire $stagiaire, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$stagiaire->getId(), $request->get('_token'))) {
            $entityManager->remove($stagiaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_stagiaire_index', [], Response::HTTP_SEE_OTHER);
    }
}

//wwwwwwwwwwwwwwww
