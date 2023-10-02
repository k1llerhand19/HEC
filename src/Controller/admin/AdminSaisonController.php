<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Saison;
use App\Repository\SaisonRepository;
use App\Form\SaisonType;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AdminSaisonController extends AbstractController
{
    #[Route('/admin/saison/calendrier/new', name: 'calendrier.new')]
    public function new(Request $request,  EntityManagerInterface $manager, SluggerInterface $slugger): Response
    {   $calendrier = new Saison();
        $form_calendrier = $this->createForm(SaisonType::class,$calendrier);
        $form_calendrier -> handleRequest($request);
    
        if( $form_calendrier->isSubmitted() && $form_calendrier->isValid()){

            $brochureFilePdf = $form_calendrier->get('nomDoc')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($brochureFilePdf) {
                $originalFilename = pathinfo($brochureFilePdf->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFilePdf->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFilePdf->move(
                        $this->getParameter('brochures_directory_calendrier'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                
                // updates the 'brochureFilePdfname' property to store the PDF file name
                // instead of its contents
                $calendrier->setNomDoc($newFilename);
            }
            
            $manager->persist($calendrier);
            $manager->flush();

            return $this->redirectToRoute('saison.calendrier',[
            ]);
        }

        return $this->render('saison/admin/newCalendrier.html.twig', [
            'form_calendrier' => $form_calendrier->createView()
        ]);
    }
}
