<?php

namespace App\Controller;

use Symfony\Component\Filesystem\Filesystem;
use App\Entity\Image;
use App\Form\ImageForm;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/image')]
final class AdminImageController extends AbstractController
{
    #[Route(name: 'app_admin_image_index', methods: ['GET'])]
    public function index(ImageRepository $imageRepository): Response
    {
        return $this->render('admin_image/index.html.twig', [
            'images' => $imageRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_image_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $image = new Image();
        $image->setDateUpload(new \DateTime());
        $form = $this->createForm(ImageForm::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('chemin')->getData();

            if ($imageFile) {
                $image->setNomImage($imageFile->getClientOriginalName());
                $image->setMimeType($imageFile->getMimeType());
                $filesystem = new FileSystem();
                if (!$filesystem->exists($this->getParameter('images_directory'))) {
                    $filesystem->mkdir($this->getParameter('images_directory'));
                }
                $root = $this->getParameter('root_dir') . '/';
                $imageFile->move($this->getParameter('images_directory'), $imageFile->getClientOriginalName());
                $image->setChemin($root . $image->getNomImage());

            }

            $entityManager->persist($image);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_image_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_image/new.html.twig', [
            'image' => $image,
            'form' => $form,
        ]);

    }

    #[Route('/{id}', name: 'app_admin_image_show', methods: ['GET'])]
    public function show(Image $image): Response
    {
        return $this->render('admin_image/show.html.twig', [
            'image' => $image,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_image_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Image $image, EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        $form = $this->createForm(ImageForm::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('chemin')->getData();

            if ($imageFile) {
                // Supprimer l'ancien fichier si il existe
                $filesystem = new FileSystem();
                if ($image->getChemin() && $filesystem->exists($image->getChemin())) {
                    $filesystem->remove($image->getChemin());
                }

                // Traiter le nouveau fichier
                $image->setNomImage($imageFile->getClientOriginalName());
                $image->setMimeType($imageFile->getMimeType());
                $image->setDateUpload(new \DateTime());

                $root = $this->getParameter('root_dir') . '/';
                $imageFile->move($this->getParameter('images_directory'), $imageFile->getClientOriginalName());
                $image->setChemin($root . $imageFile->getClientOriginalName());

            }

            $entityManager->flush();

            return $this->redirectToRoute('app_admin_image_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin_image/edit.html.twig', [
            'image' => $image,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_image_delete', methods: ['POST'])]
    public function delete(Request $request, Image $image, EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        if ($this->isCsrfTokenValid('delete' . $image->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($image);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_image_index', [], Response::HTTP_SEE_OTHER);


    }

}
