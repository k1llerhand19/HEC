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

use App\Entity\Decouverte;
use App\Repository\DecouverteRepository;
use App\Form\DecouverteType;

class AdminDecouverteController extends AbstractController
{
    #[Route('/admin/decouverte/new', name: 'decouverte.new')]
    public function new(Request $request,  EntityManagerInterface $manager, SluggerInterface $slugger): Response
    {
        $decouverte = new Decouverte();
        $form_decouverte = $this->createForm(DecouverteType::class,$decouverte);
        $form_decouverte -> handleRequest($request);
    
        if( $form_decouverte->isSubmitted() && $form_decouverte->isValid()){

            $brochureFiledecouverte = $form_decouverte->get('nomAffiche')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($brochureFiledecouverte) {
                $originalFilename = pathinfo($brochureFiledecouverte->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFiledecouverte->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFiledecouverte->move(
                        $this->getParameter('brochures_directory_decouverte'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                
                // updates the 'brochureFiledecouvertename' property to store the PDF file name
                // instead of its contents
                $decouverte->setNomAffiche($newFilename);
            }
            
            $manager->persist($decouverte);
            $manager->flush();

            return $this->redirectToRoute('app_decouverte',[
            ]);
        }
        return $this->render('decouverte/admin/newDecouverte.html.twig', [
            'form_decouverte' => $form_decouverte->createView()
        ]);
    }
}
