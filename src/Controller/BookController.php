<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

final class BookController extends AbstractController
{
    #[Route('/books', name: 'books', methods: ['GET'])]
    public function getBooks(BookRepository $bookRepository, SerializerInterface $serializer): JsonResponse
    {

        $booklist = $bookRepository->findAll();
        $jsonBookList = $serializer->serialize($booklist,'json');
        
        return new JsonResponse($jsonBookList,Response::HTTP_OK,[],true);
    }

    #[Route('/books/{id}', name: 'book_by_id', methods: ['GET'])]
    public function getBookById(int $id, BookRepository $bookRepository, SerializerInterface $serializer): JsonResponse
    {

        $book = $bookRepository->find($id);
        if ($book)
        {
            $jsonBook = $serializer->serialize($book,'json');
            return new JsonResponse($jsonBook,Response::HTTP_OK,[],true);
        }
        return new JsonResponse(null,Response::HTTP_NOT_FOUND);
    }
}
