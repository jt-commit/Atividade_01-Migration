<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;

class BookApiController extends Controller
{
    // Listar todos os livros
    public function index()
    {
        return response()->json(
            Book::with(['author', 'publisher', 'category'])->get()
        );
    }

    // Mostrar um livro
    public function show(Book $book)
    {
        return response()->json(
            $book->load(['author', 'publisher', 'category'])
        );
    }

    // Criar um livro
    public function store(Request $request)
    {
        $book = Book::create($request->all());

        return response()->json($book, 201);
    }

    // Atualizar um livro
    public function update(Request $request, Book $book)
    {
        $book->update($request->all());

        return response()->json($book);
    }

    // Excluir um livro
    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json([
            'message' => 'Livro excluído com sucesso.'
        ]);
    }
}