<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Repository\EquipeRepository;

class EquipeController extends AbstractController
{
    #[Route('/equipe', name: 'app_equipe')]
    public function index(EquipeRepository $equipeRepository, Request $request): Response
    {
        //$Id = $request->query->get('Equipe');
        $Id = $request->request->get('Equipe');

        $showEquipe  = $equipeRepository->find($Id);
        return $this->render('equipe/index.html.twig', [
            'showEquipe' => $showEquipe,
        ]);
    }
}
