<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class BookController extends AbstractController
{
    public function addBook(Request $request): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($book);
            $entityManager->flush();

            $this->addFlash('success', 'Book successfully added!');
            
            return $this->redirectToRoute('book_index'); 
        }

        return $this->render('book/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function viewBook($id): Response
    {
        $book = $this->getDoctrine()->getRepository(Book::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException('Book not found');
        }

        return $this->render('book/viewbook.html.twig', [
            'book' => $book,
        ]);
    }


    public function index(): Response
    {
        $books = $this->getDoctrine()->getRepository(Book::class)->findAll();

        return $this->render('book/index.html.twig', [
            'books' => $books,
        ]);
    }

public function updateBook(Request $request, $id): Response
{
    $entityManager = $this->getDoctrine()->getManager();
    $book = $entityManager->getRepository(Book::class)->find($id);

    if (!$book) {
        throw $this->createNotFoundException('Book not found');
    }

    $form = $this->createForm(BookType::class, $book);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->flush();

        $this->addFlash('success', 'Book successfully updated!');

        return $this->redirectToRoute('book_index');
    }

    return $this->render('book/update.html.twig', [
        'form' => $form->createView(),
    ]);
}

}