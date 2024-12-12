<?php

namespace App\Controller;


use App\Entity\Book;
use App\Form\BookFormType;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/book')]
class BookController extends AbstractController
{

    #[Route('/', name: 'app_book_index')]
    public function index(BookRepository $bookRepository): Response
    {
        $books = $bookRepository->findAll();

        return $this->render('book/index.html.twig', [
            'books' => $books,
        ]);
    }

    #[Route('/show/{id}', name: 'app_book_show')]
    public function show(int $id, BookRepository $bookRepository): Response
    {
        $book = $bookRepository->find($id);

        if ($book) {
            return $this->render('book/show.html.twig', [
                'pageTitle' => $book->getTitle(),
                'pageHeadline' => 'Details for ' . $book->getTitle(),
                'book' => $book,
            ]);
        } else {
            return new Response('Buch gibt es nicht!');
        }
    }

    #[Route('/edit/{id}', name: 'app_book_edit')]
    public function edit(Book $book, EntityManagerInterface $entityManager, Request $request): Response
    {
        $form = $this->createForm(BookFormType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $book = $form->getData();

            $entityManager->persist($book);
            $entityManager->flush();
            return $this->redirectToRoute('app_book_show', ['id' => $book->getId()]);
        }
        return $this->render('book/edit.html.twig', ['form' => $form->createView(), 'pageTitle' => 'book Übersicht',
            'pageHeadline' => 'Alle verfügbaren Bücher']);
    }

    #[Route('/delete/{id}', name: 'app_book_delete')]
    public function delete(Book $book, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute('app_book_index');
    }

    #[Route('/new', name: 'app_book_new')]
    public function new(EntityManagerInterface $entityManager, Request $request): Response
    {
        $book = new Book();
        $form = $this->createForm(BookFormType::class, $book, [
            'action' => $this->generateUrl('app_book_new'),
            'method' => 'POST',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $book= $form->getData();

            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('app_book_show', ['id' => $book->getId()]);
        } else {
            $form = $this->createForm(BookFormType::class, $book);


            return $this->render('book/new.html.twig',['form' => $form->createView()]);
        }
    }
}