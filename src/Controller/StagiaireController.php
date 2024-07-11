<?php

namespace App\Controller;

use App\Entity\Stagiaire;
use App\Form\StagiaireType;
use App\Repository\StagiaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;
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
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $stagiaire = new Stagiaire();
        $form = $this->createForm(StagiaireType::class, $stagiaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($stagiaire);
            $entityManager->flush();

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
        return $this->render('stagiaire/show.html.twig', [
            'stagiaire' => $stagiaire,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_stagiaire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Stagiaire $stagiaire, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StagiaireType::class, $stagiaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_stagiaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('stagiaire/edit.html.twig', [
            'stagiaire' => $stagiaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_stagiaire_delete', methods: ['POST'])]
    public function delete(Request $request, Stagiaire $stagiaire, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$stagiaire->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($stagiaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_stagiaire_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/stagiaire/reset-password", name="app_stagiaire_reset_password", methods={"POST"})
     */
    public function resetPassword(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): RedirectResponse
    {
        $selectedIds = $request->request->get('selected', []);

        if (empty($selectedIds)) {
            $this->addFlash('warning', 'No stagiaires selected.');
            return $this->redirectToRoute('app_stagiaire_index');
        }

        foreach ($selectedIds as $id) {
            $stagiaire = $em->getRepository(Stagiaire::class)->find($id);

            if ($stagiaire) {
                // Generate a new random password
                $newPassword = bin2hex(random_bytes(4));
                $hashedPassword = $passwordHasher->hashPassword($stagiaire, $newPassword);

                // Update the password
                $stagiaire->setPassword($hashedPassword);
                $em->persist($stagiaire);

                // Add a flash message to show the new password
                $this->addFlash('success', "Password for stagiaire ID {$stagiaire->getId()} reset to: $newPassword");
            } else {
                $this->addFlash('error', "Stagiaire with ID {$id} not found.");
            }
        }

        $em->flush();

        return $this->redirectToRoute('app_stagiaire_index');
    }


}

