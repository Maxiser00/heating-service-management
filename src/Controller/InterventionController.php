<?php

namespace App\Controller;

use App\Entity\Intervention;
use App\Form\InterventionType;
use App\Repository\InterventionRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/intervention')]
class InterventionController extends AbstractController
{
    #[Route('/', name: 'app_intervention_index', methods: ['GET'])]
    public function index(InterventionRepository $interventionRepository): Response
    {
        $this->denyUnlessAdminOrSecretaire();
        return $this->render('intervention/index.html.twig', [
            'interventions' => $interventionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_intervention_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, InterventionRepository $interventionRepository, UserRepository $userRepository): Response
    {
        $this->denyUnlessAdminOrSecretaire();

        $intervention = new Intervention();
        $users = $userRepository->findAll();

        $form = $this->createForm(InterventionType::class, $intervention, [
            'users' => $users,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $timestamp = $intervention->getTimestamp();
            $chauffagiste = $intervention->getUser();
            $vehicule = $intervention->getVehicle();

            $conflictsUser = $interventionRepository->findBy([
                'Timestamp' => $timestamp,
                'user' => $chauffagiste,
            ]);

            if ($conflictsUser) {
                $this->addFlash('error', 'Ce chauffagiste a déjà une intervention à cette date.');
                return $this->render('intervention/new.html.twig', [
                    'form' => $form,
                ]);
            }

            if ($vehicule) {
                $conflictsVehicule = $interventionRepository->findBy([
                    'Timestamp' => $timestamp,
                    'vehicle' => $vehicule,
                ]);

                if ($conflictsVehicule) {
                    $this->addFlash('error', 'Ce véhicule est déjà utilisé à cette date.');
                    return $this->render('intervention/new.html.twig', [
                        'form' => $form,
                    ]);
                }
            }

            $entityManager->persist($intervention);
            $entityManager->flush();

            return $this->redirectToRoute('app_intervention_index');
        }

        return $this->render('intervention/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_intervention_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Intervention $intervention, EntityManagerInterface $entityManager, InterventionRepository $interventionRepository, UserRepository $userRepository): Response
    {
        $this->denyUnlessAdminOrSecretaire();

        $users = $userRepository->findAll();

        $form = $this->createForm(InterventionType::class, $intervention, [
            'users' => $users,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $timestamp = $intervention->getTimestamp();
            $chauffagiste = $intervention->getUser();
            $vehicule = $intervention->getVehicle();

            $conflictUser = $interventionRepository->createQueryBuilder('i')
                ->where('i.Timestamp = :time')
                ->andWhere('i.user = :user')
                ->andWhere('i != :current')
                ->setParameter('time', $timestamp)
                ->setParameter('user', $chauffagiste)
                ->setParameter('current', $intervention)
                ->getQuery()
                ->getResult();

            if ($conflictUser) {
                $this->addFlash('error', 'Ce chauffagiste a déjà une autre intervention à cette date.');
                return $this->render('intervention/edit.html.twig', [
                    'form' => $form,
                    'intervention' => $intervention,
                ]);
            }

            if ($vehicule) {
                $conflictVehicule = $interventionRepository->createQueryBuilder('i')
                    ->where('i.Timestamp = :time')
                    ->andWhere('i.vehicle = :vehicule')
                    ->andWhere('i != :current')
                    ->setParameter('time', $timestamp)
                    ->setParameter('vehicule', $vehicule)
                    ->setParameter('current', $intervention)
                    ->getQuery()
                    ->getResult();

                if ($conflictVehicule) {
                    $this->addFlash('error', 'Ce véhicule est déjà utilisé à cette date.');
                    return $this->render('intervention/edit.html.twig', [
                        'form' => $form,
                        'intervention' => $intervention,
                    ]);
                }
            }

            $entityManager->flush();
            return $this->redirectToRoute('app_intervention_index');
        }

        return $this->render('intervention/edit.html.twig', [
            'form' => $form,
            'intervention' => $intervention,
        ]);
    }

    #[Route('/mes-interventions', name: 'app_intervention_mes', methods: ['GET'])]
    public function mesInterventions(InterventionRepository $interventionRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_CHAUFFAGISTE');

        $user = $this->getUser();
        $interventions = $interventionRepository->findBy(['user' => $user]);

        return $this->render('intervention/indexChauffagiste.html.twig', [
            'interventions' => $interventions,
        ]);
    }

    #[Route('/{id}', name: 'app_intervention_show', methods: ['GET'])]
    public function show(Intervention $intervention): Response
    {
        if ($this->isGranted('ROLE_CHAUFFAGISTE')) {
            if ($intervention->getUser() !== $this->getUser()) {
                throw $this->createAccessDeniedException('Accès refusé à cette intervention.');
            }
        } else {
            $this->denyUnlessAdminOrSecretaire();
        }

        return $this->render('intervention/show.html.twig', [
            'intervention' => $intervention,
        ]);
    }

    #[Route('/{id}', name: 'app_intervention_delete', methods: ['POST'])]
    public function delete(Request $request, Intervention $intervention, EntityManagerInterface $entityManager): Response
    {
        $this->denyUnlessAdminOrSecretaire();

        if ($this->isCsrfTokenValid('delete' . $intervention->getId(), $request->request->get('_token'))) {
            $entityManager->remove($intervention);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_intervention_index');
    }

    #[Route('/{id}/remarque', name: 'app_intervention_remarque', methods: ['GET', 'POST'])]
    public function ajouterRemarque(Request $request, Intervention $intervention, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$this->isGranted('ROLE_CHAUFFAGISTE') || $intervention->getUser() !== $user) {
            throw $this->createAccessDeniedException("Vous ne pouvez modifier que vos propres interventions.");
        }

        $form = $this->createForm(RemarqueType::class, $intervention);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Remarque ajoutée avec succès.');
            return $this->redirectToRoute('app_intervention_show', ['id' => $intervention->getId()]);
        }

        return $this->render('intervention/remarque.html.twig', [
            'form' => $form,
            'intervention' => $intervention,
        ]);
    }

    private function denyUnlessAdminOrSecretaire(): void
    {
        if (!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_SECRETAIRE')) {
            throw $this->createAccessDeniedException();
        }
    }
}
