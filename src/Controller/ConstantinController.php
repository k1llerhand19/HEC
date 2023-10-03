<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

use App\Repository\ConstantinRepository;

class ConstantinController extends AbstractController
{
    #[Route('/constantin', name: 'app_constantin')]
    public function index(ConstantinRepository $constantinRepository): Response
    {
        $showConstantin = $constantinRepository->findOneBy([],['id' => 'DESC']);
        
        return $this->render('constantin/index.html.twig', [
            'showConstantin' => $showConstantin,
        ]);
    }
}
