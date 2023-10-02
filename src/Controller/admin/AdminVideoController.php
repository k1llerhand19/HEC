<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use App\Entity\Video;
use App\Repository\VideoRepository;
use App\Form\VideoType;

class AdminVideoController extends AbstractController
{
    #[Route('/admin/video/new', name: 'video.add')]
    public function new(Request $request,  EntityManagerInterface $manager, SluggerInterface $slugger): Response
    {
        $video = new Video();
        $form_video = $this->createForm(VideoType::class,$video);
        $form_video -> handleRequest($request);
    
        if( $form_video->isSubmitted() && $form_video->isValid()){

            $brochureFilevideo = $form_video->get('nomVideo')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($brochureFilevideo) {
                $originalFilename = pathinfo($brochureFilevideo->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFilevideo->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFilevideo->move(
                        $this->getParameter('brochures_directory_video'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                
                // updates the 'brochureFilevideoname' property to store the PDF file name
                // instead of its contents
                $video->setNomVideo($newFilename);
            }
            
            $manager->persist($video);
            $manager->flush();

            return $this->redirectToRoute('app_video',[
            ]);
        }
        return $this->render('video/admin/newVideo.html.twig', [
            'form_video' => $form_video->createView()
        ]);
    }
}
