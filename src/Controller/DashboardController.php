<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dashboard')]
class DashboardController extends AbstractController
{
    #[Route('/', name: 'dashboard')]
    #[Route('/admin', name: 'admin_dashboard')]
    #[Route('/secretaire', name: 'secretaire_dashboard')]
    #[Route('/chauffagiste', name: 'chauffagiste_dashboard')]
    public function index(): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->render('dashboard/admin.html.twig');
        }

        if ($this->isGranted('ROLE_SECRETAIRE')) {
            return $this->render('dashboard/secretaire.html.twig');
        }

        if ($this->isGranted('ROLE_CHAUFFAGISTE')) {
            return $this->render('dashboard/chauffagiste.html.twig');
        }

        throw $this->createAccessDeniedException('Vous ne pouvez pas accéder à ce tableau de bord.');
    }
}
