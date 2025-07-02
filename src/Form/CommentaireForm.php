<?php

namespace App\Form;

use App\Entity\Commentaire;
use App\Entity\Post;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentaireForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateHeureCreation')
            ->add('contenu', TextareaType::class ,[
                'label' => 'Contenu du commentaire'
            ])
            /*->add('auteur', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'username',
            ])
            ->add('post', EntityType::class, [
                'class' => Post::class,
                'choice_label' => 'titre',
            ])*/
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => ['class' => 'btn btn-primary btn-block']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commentaire::class,
        ]);
    }
}
