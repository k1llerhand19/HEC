<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

use App\Repository\OrganigrameRepository;


class OrganigrameController extends AbstractController
{
    #[Route('/organigrame', name: 'app_organigrame')]
    public function index(OrganigrameRepository $organigrameRepository): Response
    {

        $showOrganigrame1  = $organigrameRepository->find(1);
        $organigrammes = $organigrameRepository->findBy([], ['id' => 'ASC'], null, 1);
        
        return $this->render('organigrame/index.html.twig', [
            'controller_name' => 'OrganigrameController',
            'showOrganigrame' => $organigrammes,
            'showOrganigrame1' => $showOrganigrame1


        ]);
    }
}
