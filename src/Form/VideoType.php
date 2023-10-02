<?php

namespace App\Form;

use App\Entity\Video;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class VideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomVideo', FileType::class, [
                'label' => 'Sélectionner la Vidéo',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024M', // Réglez la taille maximale du fichier vidéo, par exemple, 1024 Mo
                        'mimeTypes' => [
                            'video/mp4',
                            'video/mpeg',
                            'video/quicktime',
                            'video/x-msvideo',
                            'video/x-ms-wmv',
                            // Ajoutez les types MIME vidéo que vous souhaitez autoriser ici
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger un fichier vidéo valide (mp4, mpeg, avi, wmv, etc.)',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Video::class,
        ]);
    }
}
