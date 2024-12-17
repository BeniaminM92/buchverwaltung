<?php

namespace App\Controller;

use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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


}
