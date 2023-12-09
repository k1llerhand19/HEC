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

use App\Entity\Equipe;
use App\Repository\EquipeRepository;
use App\Form\EquipeType;


class AdminEquipeController extends AbstractController
{
    #[Route('/admin/equipe/new', name: 'equipe.new')]
    public function AjouterEquipe(Request $request,  EntityManagerInterface $manager, SluggerInterface $slugger): Response
    {   $equipe = new Equipe();
        $form_equipe = $this->createForm(EquipeType::class, $equipe);
        $form_equipe -> handleRequest($request);
        
    
        if( $form_equipe->isSubmitted() && $form_equipe->isValid()){

            $brochureFilePhotoscoach = $form_equipe->get('PhotoId')->getData();

            if ($brochureFilePhotoscoach) {
                $originalFilename = pathinfo($brochureFilePhotoscoach->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFilePhotoscoach->guessExtension();

                try {
                    $brochureFilePhotoscoach->move(
                        $this->getParameter('brochures_directory_photos_Coach'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }

                // Stockez le nom du fichier dans l'entité Organigrame
                $equipe->setPhotoId($newFilename);
                //dd($organigrame);

            } else {
                // Gérez le cas où le fichier est manquant
                $this->addFlash('error', 'Veuillez sélectionner un fichier.');
                return $this->redirectToRoute('organigrame.new');
            }

            $brochureFilePhotosEquipe = $form_equipe->get('PhotoEquipe')->getData();

            if ($brochureFilePhotosEquipe) {
                $originalFilename = pathinfo($brochureFilePhotosEquipe->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilenameEquipe = $safeFilename.'-'.uniqid().'.'.$brochureFilePhotosEquipe->guessExtension();

                try {
                    $brochureFilePhotosEquipe->move(
                        $this->getParameter('brochures_directory_photos_Equipe'),
                        $newFilenameEquipe
                    );
                } catch (FileException $e) {
                }

                // Stockez le nom du fichier dans l'entité Organigrame
                $equipe->setPhotoEquipe($newFilenameEquipe);
                //dd($organigrame);

            } else {
                // Gérez le cas où le fichier est manquant
                $this->addFlash('error', 'Veuillez sélectionner un fichier.');
                return $this->redirectToRoute('organigrame.new');
            }


            $manager->persist($equipe);
            $manager->flush();
            return $this->redirectToRoute('app_equipe', []);
        }

        return $this->render('equipe/admin/NewEquipe.html.twig', [
            'form_equipe' => $form_equipe->createView()
            
        ]);
    }
}
