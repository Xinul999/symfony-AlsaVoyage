<?php

namespace App\Form;

use App\Entity\Image;
use App\Entity\Post;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ImageForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('chemin', FileType::class, [
                'label'       => 'Fichier image',
                'mapped'      => false,
                'required'    => true,
                'constraints' => [
                    new File(
                        maxSize: '5M',
                        mimeTypes: [
                            'image/jpeg',
                            'image/png',
                            'image/webp',
                        ],
                        mimeTypesMessage: 'Veuillez télécharger une image JPEG, PNG ou WebP valide.'
                    ),
                ],
            ])
            ->add('dateUpload')
            ->add('post', EntityType::class, [
                'class'        => Post::class,
                'choice_label' => fn(Post $post) => $post->getAuteur()->getUsername() . ' - ' . $post->getTitre(),
                'label'        => 'Post'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
                'attr'  => ['class' => 'btn btn-primary'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}
