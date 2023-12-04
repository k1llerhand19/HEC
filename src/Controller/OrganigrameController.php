<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrganigrameController extends AbstractController
{
    #[Route('/organigrame', name: 'app_organigrame')]
    public function index(): Response
    {
        return $this->render('organigrame/index.html.twig', [
            'controller_name' => 'OrganigrameController',
        ]);
    }
}
