<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SaisonController extends AbstractController
{
    #[Route('/saison/calendrier', name: 'saison.calendrier')]
    public function index(): Response
    {
        return $this->render('saison/index.html.twig', [
            'controller_name' => 'SaisonController',
        ]);
    }
}
