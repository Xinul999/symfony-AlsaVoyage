<?php

namespace App\Controller;

use App\Form\ContactForm;
use App\Helper\Helper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request): Response
    {

        $form = $this->createForm(ContactForm::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            if(!Helper::checkEmail($data['email'])){
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

}
