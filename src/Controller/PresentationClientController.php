<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PresentationClientController extends AbstractController
{
    #[Route('/presentation/client', name: 'app_presentation_client')]
    public function index(): Response
    {
        $informationBob = [
            'name' => 'Bob',
            'age' => 30,
            'totalCountries' => 10
        ];
        return $this->render('presentation_client/index.html.twig',[
            'bob' => $informationBob
        ]);
    }
}
