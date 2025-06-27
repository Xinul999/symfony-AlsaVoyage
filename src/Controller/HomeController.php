<?php

namespace App\Controller;

use App\Repository\PostRepository;
use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');

    }

    #[Route('/postList', name: 'app_postList')]
    public function postList(PostRepository $postRepository): Response
    {
        return $this->render('home/postList.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);

    }

    #[Route('/postList/{id}', name: 'app_postList_show', methods: ['GET'])]
    public function show(Post $post): Response
    {
        return $this->render('home/post.html.twig', [
            'post' => $post,
        ]);
    }

}
