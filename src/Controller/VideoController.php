<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

use App\Repository\VideoRepository;

class VideoController extends AbstractController
{
    #[Route('/video', name: 'app_video')]
    public function index(VideoRepository $videoRepository): Response
    {
        $showVideos  = $videoRepository->findBy([],['id' => 'DESC']);

        return $this->render('video/index.html.twig', [
            'showVideos' => $showVideos,
        ]);
    }
}
