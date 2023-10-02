<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

use App\Repository\PhotosRepository;

class PhotosController extends AbstractController
{
    #[Route('/photos', name: 'app_photos')]
    public function index(PhotosRepository $photosRepository): Response
    {
        $showImages  = $photosRepository->findBy([],['id' => 'DESC']);
        
        return $this->render('photos/index.html.twig', [
            'showImages' => $showImages,
        ]);
    }
}
