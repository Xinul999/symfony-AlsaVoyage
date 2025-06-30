<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request): Response
    {
        $form = $this->createFormBuilder()
            ->add('nom', TextType::class, [
                'label' => 'Votre nom',
                'attr' => ['required' => true]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre adresse email',
                'attr' => ['required' => true]
            ])
            ->add('sujet', TextType::class, [
                'label' => 'Sujet du message',
                'attr' => ['required' => true]
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Votre message',
                'attr' => ['required' => true]
            ])
            ->add('submit',SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => ['class' => 'btn btn-primary']
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            if(!$this->checkEmail($data['email'])){
                $this->addFlash('error', 'Votre adresse email est invalide!');
            }
            else{
                $this->addFlash('success', 'Votre message a été envoyé avec succès!');
            }

            return $this->redirectToRoute('app_contact');
        }
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function checkEmail($email): bool {
        $pattern = '/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/';
        return preg_match($pattern, $email);

    }
}
