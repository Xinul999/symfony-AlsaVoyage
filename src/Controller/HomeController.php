<?php

namespace App\Controller;

use App\Repository\PostRepository;
use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Commentaire;
use App\Form\CommentaireForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(PostRepository $postRepository): Response
    {
        $post_last_3 = $postRepository->findBy([],['dateHeureCreation' => 'DESC'], 3);
        return $this->render('home/index.html.twig', [
            'posts' => $post_last_3
        ]);

    }

    #[Route('/postList', name: 'app_postList')]
    public function postList(PostRepository $postRepository): Response
    {
        return $this->render('home/postList.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);

    }

    #[Route('/postList/{id}', name: 'app_postList_show', methods: ['GET', 'POST'])]
    public function show(Post $post, Request $request, EntityManagerInterface $em): Response
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireForm::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire->setAuteur($this->getUser());
            $commentaire->setPost($post);


            $em->persist($commentaire);
            $em->flush();

            return $this->redirectToRoute('app_postList_show', ['id' => $post->getId()]);
        }
        return $this->render('home/post.html.twig', [
            'post' => $post,
            'commentaire_form' => $form->createView(),
        ]);
    }

}
