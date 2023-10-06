<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

use App\Repository\DecouverteRepository;

class DecouverteController extends AbstractController
{
    #[Route('/decouverte', name: 'app_decouverte')]
    public function index(DecouverteRepository $decouverteRepository): Response
    {
        $showDecouverte = $decouverteRepository->findOneBy([],['id' => 'DESC']);

        return $this->render('decouverte/index.html.twig', [
            'showDecouverte' => $showDecouverte,
        ]);
    }
}
