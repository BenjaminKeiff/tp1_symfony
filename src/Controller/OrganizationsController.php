<?php

namespace App\Controller;

use App\Entity\Organizations;
use App\Form\OrganizationsType;
use App\Repository\OrganizationsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/organizations')]
#[IsGranted('ROLE_ADMIN')]

class OrganizationsController extends AbstractController
{
    #[Route('/', name: 'app_organizations_index', methods: ['GET'])]
    public function index(OrganizationsRepository $organizationsRepository): Response
    {
        return $this->render('organizations/index.html.twig', [
            'organizations' => $organizationsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_organizations_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $organization = new Organizations();
        $form = $this->createForm(OrganizationsType::class, $organization);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($organization);
            $entityManager->flush();

            return $this->redirectToRoute('app_organizations_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('organizations/new.html.twig', [
            'organization' => $organization,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_organizations_show', methods: ['GET'])]
    public function show(Organizations $organization): Response
    {
        return $this->render('organizations/show.html.twig', [
            'organization' => $organization,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_organizations_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Organizations $organization, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OrganizationsType::class, $organization);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_organizations_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('organizations/edit.html.twig', [
            'organization' => $organization,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_organizations_delete', methods: ['POST'])]
    public function delete(Request $request, Organizations $organization, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$organization->getId(), $request->request->get('_token'))) {
            $entityManager->remove($organization);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_organizations_index', [], Response::HTTP_SEE_OTHER);
    }
}
