<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginFormAuthenticatorController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authUtils): Response
    {
        // Si l’utilisateur est déjà connecté, on le redirige vers l’index des articles
        if ($this->getUser()) {
            return $this->redirectToRoute('article');
        }

        // Récupère l’erreur (s’il y en a une) et le dernier username saisi
        $error        = $authUtils->getLastAuthenticationError();
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('loginformauthenticator/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        // Cette méthode ne doit jamais être exécutée directement,
        // la déconnexion est gérée par le firewall.
        throw new \LogicException('Cette méthode est interceptée par le firewall.');
    }
}



