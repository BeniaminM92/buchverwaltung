<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorFormType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/author')]
class AuthorController extends AbstractController
{
    #[Route('/', name: 'app_author_index')]
    public function index(AuthorRepository $authorRepository): Response
    {
        $authors = $authorRepository->findAll();

        return $this->render('author/index.html.twig', [
            'authors' => $authors
        ]);
    }

    #[Route('/show/{id}', name: 'app_author_show')]
    public function show(int $id, AuthorRepository $authorRepository): Response
    {
        $author = $authorRepository->find($id);

        if ($author) {
            return $this->render('author/show.html.twig', [
                'author' => $author
            ]);
        } else {
            return new Response('AutorIn gibt es nicht!');
        }
    }

    #[Route('/edit/{id}', name: 'app_author_edit')]
    public function edit(Author $author, EntityManagerInterface $entityManager, Request $request): Response
    {
        $form = $this->createForm(AuthorFormType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $author = $form->getData();

            $entityManager->persist($author);
            $entityManager->flush();
            return $this->redirectToRoute('app_author_show', ['id' => $author->getId()]);
        }
        return $this->render('author/edit.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/delete/{id}', name: 'app_author_delete')]
    public function delete(Author $author, EntityManagerInterface $entityManager): Response
    {
        foreach ($author->getBooks() as $book) {
            $book->setAuthor(null);
        }

        $entityManager->remove($author);
        $entityManager->flush();

        return $this->redirectToRoute('app_author_index');
    }

    #[Route('/new', name: 'app_author_new')]
    public function new(EntityManagerInterface $entityManager, Request $request): Response
    {
        $author = new Author();
        $form = $this->createForm(AuthorFormType::class, $author, [
            'action' => $this->generateUrl('app_author_new'),
            'method' => 'POST',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $author= $form->getData();

            $entityManager->persist($author);
            $entityManager->flush();

            return $this->redirectToRoute('app_author_show', ['id' => $author->getId()]);
        } else {
            $form = $this->createForm(AuthorFormType::class, $author);


            return $this->render('author/new.html.twig', ['form' => $form->createView()]);
        }
    }

}
