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

use App\Entity\Photos;
use App\Repository\PhotosRepository;
use App\Form\PhotosType;

class AdminPhotosController extends AbstractController
{
    #[Route('/admin/photos/new', name: 'photos.new')]
    public function new(Request $request,  EntityManagerInterface $manager, SluggerInterface $slugger): Response
    {
        $photos = new Photos();
        $form_photos = $this->createForm(PhotosType::class,$photos);
        $form_photos -> handleRequest($request);
    
        if( $form_photos->isSubmitted() && $form_photos->isValid()){

            $brochureFilePhotos = $form_photos->get('nomPhoto')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($brochureFilePhotos) {
                $originalFilename = pathinfo($brochureFilePhotos->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFilePhotos->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFilePhotos->move(
                        $this->getParameter('brochures_directory_photos'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                
                // updates the 'brochureFilePhotosname' property to store the PDF file name
                // instead of its contents
                $photos->setNomPhoto($newFilename);
            }
            
            $manager->persist($photos);
            $manager->flush();

            return $this->redirectToRoute('app_photos',[
            ]);
        }

        return $this->render('photos/admin/newPhotos.html.twig', [
            'form_photos' => $form_photos->createView()
        ]);
    }
}
