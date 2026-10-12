<?php

namespace App\Controller;

use App\Entity\Fault;
use App\Form\FaultType;
use App\Repository\FaultRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/fault')]
class FaultController extends AbstractController
{
    #[Route('/', name: 'app_fault_index', methods: ['GET'])]
    public function index(FaultRepository $faultRepository): Response
    {
        $this->denyUnlessAdminOrSecretaire();
        return $this->render('fault/index.html.twig', [
            'faults' => $faultRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_fault_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyUnlessAdminOrSecretaire();

        $fault = new Fault();
        $form = $this->createForm(FaultType::class, $fault);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($fault);
            $entityManager->flush();
            return $this->redirectToRoute('app_fault_index');
        }

        return $this->render('fault/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_fault_show', methods: ['GET'])]
    public function show(Fault $fault): Response
    {
        $this->denyUnlessAdminOrSecretaire();
        return $this->render('fault/show.html.twig', [
            'fault' => $fault,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_fault_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Fault $fault, EntityManagerInterface $entityManager): Response
    {
        $this->denyUnlessAdminOrSecretaire();

        $form = $this->createForm(FaultType::class, $fault);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_fault_index');
        }

        return $this->render('fault/edit.html.twig', [
            'form' => $form,
            'fault' => $fault,
        ]);
    }

    #[Route('/{id}', name: 'app_fault_delete', methods: ['POST'])]
    public function delete(Request $request, Fault $fault, EntityManagerInterface $entityManager): Response
    {
        $this->denyUnlessAdminOrSecretaire();

        if ($this->isCsrfTokenValid('delete'.$fault->getId(), $request->request->get('_token'))) {
            $entityManager->remove($fault);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_fault_index');
    }

    private function denyUnlessAdminOrSecretaire(): void
    {
        if (!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_SECRETAIRE')) {
            throw $this->createAccessDeniedException();
        }
    }
}
