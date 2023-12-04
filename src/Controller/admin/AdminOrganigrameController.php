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

use App\Entity\Organigrame;
use App\Repository\OrganigrameRepository;
use App\Form\OrganigrameType;

class AdminOrganigrameController extends AbstractController
{
    #[Route('/admin/organigrame/new', name: 'organigrame.new')]
    public function AjouterOrganigrame(Request $request,  EntityManagerInterface $manager, SluggerInterface $slugger): Response
    {   $organigrame = new Organigrame();
        $form_organigrame = $this->createForm(organigrameType::class,$organigrame);
        $form_organigrame -> handleRequest($request);
    
        if( $form_organigrame->isSubmitted() && $form_organigrame->isValid()){

            $brochureFilePhotos = $form_organigrame->get('nom_photos')->getData();

            if ($brochureFilePhotos) {
                $originalFilename = pathinfo($brochureFilePhotos->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFilePhotos->guessExtension();

                try {
                    $brochureFilePhotos->move(
                        $this->getParameter('brochures_directory_photos_identite'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $organigrame->setNomPhotos($newFilename);
            }
            $manager->persist($organigrame);
            $manager->flush();

            return $this->redirectToRoute('app_organigrame',[
            ]);
        }

        return $this->render('organigrame/admin/NewOrganigrame.html.twig', [
            'form_organigrame' => $form_organigrame->createView()
        ]);
    }
}
