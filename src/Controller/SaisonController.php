<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ImageFormType;

use App\Entity\Saison;
use App\Repository\SaisonRepository;


class SaisonController extends AbstractController
{
    #[Route('/saison/calendrier', name: 'saison.calendrier')]
    public function index(SaisonRepository $calendrierRepository): Response
    {
        $showCalendrier  = $calendrierRepository->findOneBy([],['id' => 'DESC']);
        return $this->render('saison/index.html.twig', [
            'controller_name' => 'SaisonController',
            'showCalendrier'=>$showCalendrier
        ]);
    }
}
