<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase; // Asigurați-vă că ați importat clasa WebTestCase

class BookControllerTest extends WebTestCase
{
    public function testAddBook()
    {
        $client = static::createClient();

        $client->request('GET', '/book/add');
        $this->assertResponseIsSuccessful();

        $client->submitForm('Save', [
            'book[title]' => 'Test Book',
            'book[author]' => 'Test Author',
            'book[isbn]' => '1234567890',
            'book[publishedAt]' => '2022-01-01',
        ]);

        $this->assertResponseRedirects('/book');

        $entityManager = $client->getContainer()->get('doctrine')->getManager();
        $bookRepository = $entityManager->getRepository('App\Entity\Book');
        $book = $bookRepository->findOneBy(['title' => 'Test Book']);
        $this->assertNotNull($book);
        $this->assertEquals('Test Author', $book->getAuthor());
        $this->assertEquals('1234567890', $book->getIsbn());
        $this->assertEquals(new \DateTime('2022-01-01'), $book->getPublishedAt());
    }
}
