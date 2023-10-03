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

use App\Entity\Constantin;
use App\Repository\ConstantinRepository;
use App\Form\ConstantinType;

class AdminConstantinController extends AbstractController
{
    #[Route('/admin/constantin/new', name: 'constantin.new')]
    public function new(Request $request,  EntityManagerInterface $manager, SluggerInterface $slugger): Response
    {
        $constantin = new Constantin();
        $form_constantin = $this->createForm(ConstantinType::class,$constantin);
        $form_constantin -> handleRequest($request);
    
        if( $form_constantin->isSubmitted() && $form_constantin->isValid()){

            $brochureFileconstantin = $form_constantin->get('nomDoc')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($brochureFileconstantin) {
                $originalFilename = pathinfo($brochureFileconstantin->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFileconstantin->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFileconstantin->move(
                        $this->getParameter('brochures_directory_constantin'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                
                // updates the 'brochureFileconstantinname' property to store the PDF file name
                // instead of its contents
                $constantin->setNomDoc($newFilename);
            }
            
            $manager->persist($constantin);
            $manager->flush();

            return $this->redirectToRoute('app_constantin',[
            ]);
        }
        return $this->render('constantin/admin/newConstantin.html.twig', [
            'form_constantin' => $form_constantin->createView()
        ]);
    }
}
