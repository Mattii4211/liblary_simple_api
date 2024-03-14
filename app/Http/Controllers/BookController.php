<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Http\Repository\BookRepository;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $filter = $request->get('find') ? htmlspecialchars($request->get('find')) : null;

        $repository = new BookRepository();

        return new JsonResponse(
            [
                $repository->getBooks($filter)
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book): JsonResponse
    {
        $repository = new BookRepository();
        $data = $repository->getBookRentalDetails($book->id)->all()[0];  

        return new JsonResponse(
            [
                'name' => $book->name,
                'author' => $book->author,
                'publication_date' => $book->publication_date,
                'publishing_house' => $book->publishing_house,
                'borrowed' => $data->borrowed,
                'borrower' => $data->borrower,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
