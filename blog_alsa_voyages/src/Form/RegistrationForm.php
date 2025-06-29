<?php
// src/Form/RegistrationFormType.php
namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // le champ email, avec validation
            ->add('email', EmailType::class, [
                'label'       => 'E-mail',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir une adresse e-mail',
                    ]),
                    new Email([
                        'message' => 'Le format de l’e-mail n’est pas valide',
                    ]),
                ],
            ])

            // le champ username, avec validation
            ->add('username', TextType::class, [
                'label'       => 'Nom d’utilisateur',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un nom d’utilisateur',
                    ]),
                    new Length([
                        'min'        => 3,
                        'minMessage' => 'Le nom d’utilisateur doit faire au moins {{ limit }} caractères',
                        'max'        => 50,
                    ]),
                ],
            ])

            // les conditions d’utilisation
            ->add('agreeTerms', CheckboxType::class, [
                'label'    => 'J’accepte les conditions',
                'mapped'   => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter nos conditions.',
                    ]),
                ],
            ])

            // le mot de passe en clair (sera hashé dans le contrôleur)
            ->add('plainPassword', PasswordType::class, [
                'label'       => 'Mot de passe',
                'mapped'      => false,
                'attr'        => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un mot de passe',
                    ]),
                    new Length([
                        'min'        => 6,
                        'minMessage' => 'Votre mot de passe doit faire au moins {{ limit }} caractères',
                        'max'        => 4096,
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
