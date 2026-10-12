<?php

namespace App\Controller;

use App\Repository\InterventionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/calendrier')]
class CalendrierController extends AbstractController
{
    #[Route('/chauffagiste', name: 'app_calendrier_indexChauffagiste')]
    public function indexChauffagiste(InterventionRepository $interventionRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_CHAUFFAGISTE');

        $interventions = $interventionRepository->findByUser($this->getUser());

        $events = [];
        foreach ($interventions as $intervention) {
            $events[] = [
                'title' => ' - ' . $intervention->getWording() . ' (' . $intervention->getStatus() . ')',
                'start' => $intervention->getTimestamp()?->format('Y-m-d\TH:i:s') ?? '',
                'end' => $intervention->getTimestamp()?->format('Y-m-d\TH:i:s') ?? '',
                'description' => $intervention->getDescription(),
                'url' => $this->generateUrl('app_intervention_show', ['id' => $intervention->getId()])
            ];
        }

        return $this->render('calendrier/indexChauffagiste.html.twig', [
            'events' => json_encode($events),
        ]);
    }

    #[Route('/secretaire', name: 'app_calendrier_indexSecretaire')]
    public function indexSecretaire(InterventionRepository $interventionRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_SECRETAIRE');

        $interventions = $interventionRepository->findAll();

        $events = [];
        foreach ($interventions as $intervention) {
            $events[] = [
                'title' => ' - ' . $intervention->getWording() . ' (' . $intervention->getStatus() . ')',
                'start' => $intervention->getTimestamp()?->format('Y-m-d\TH:i:s') ?? '',
                'end' => $intervention->getTimestamp()?->format('Y-m-d\TH:i:s') ?? '',
                'description' => $intervention->getDescription(),
                'url' => $this->generateUrl('app_intervention_show', ['id' => $intervention->getId()])
            ];
        }

        return $this->render('calendrier/indexSecretaire.html.twig', [
            'events' => json_encode($events),
        ]);
    }

    #[Route('/admin', name: 'app_calendrier_index')]
    public function indexAdmin(InterventionRepository $interventionRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $interventions = $interventionRepository->findAll();

        $events = [];
        foreach ($interventions as $intervention) {
            $events[] = [
                'title' => ' - ' . $intervention->getWording() . ' (' . $intervention->getStatus() . ')',
                'start' => $intervention->getTimestamp()?->format('Y-m-d\TH:i:s') ?? '',
                'end' => $intervention->getTimestamp()?->format('Y-m-d\TH:i:s') ?? '',
                'description' => $intervention->getDescription(),
                'url' => $this->generateUrl('app_intervention_show', ['id' => $intervention->getId()])
            ];
        }

        return $this->render('calendrier/index.html.twig', [
            'events' => json_encode($events),
        ]);
    }
}
