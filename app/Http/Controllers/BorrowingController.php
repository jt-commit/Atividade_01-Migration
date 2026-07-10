<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Book;
use App\Models\Borrowing; 
use Carbon\Carbon;

class BorrowingController extends Controller
{
   public function store(Request $request, Book $book)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
    ]);

    $usuario = User::find($request->user_id);if ($usuario->debit > 0) {

    return back()->with(
        'error',
        'Este usuário possui multas pendentes.'
    );
}

$livrosEmprestados = $usuario->books()
    ->wherePivotNull('returned_at')
    ->count();

if ($livrosEmprestados >= 5) {
    return back()->with(
        'error',
        'Este usuário já possui 5 livros emprestados.'
    );
}
    // Verifica se o livro já está emprestado
    $emprestimoAberto = $book->users()
        ->wherePivotNull('returned_at')
        ->exists();

    if ($emprestimoAberto) {
        return back()->with(
            'error',
            'Este livro já está emprestado e ainda não foi devolvido.'
        );
    }

    Borrowing::create([
        'user_id' => $request->user_id,
        'book_id' => $book->id,
        'borrowed_at' => now(),
    ]);

    return redirect()->route('books.show', $book)
        ->with('success', 'Empréstimo registrado com sucesso.');
}

public function returnBook(Borrowing $borrowing)
{
    $borrowing->update([
        'returned_at' => now(),
    ]);

    $user = User::find($borrowing->user_id);

    $diasEmprestado = Carbon::parse($borrowing->borrowed_at)
    ->diffInDays(Carbon::parse($borrowing->returned_at));

    if ($diasEmprestado > 15) {

        $diasAtraso = $diasEmprestado - 15;

        $multa = $diasAtraso * 0.50;

        $user->increment('debit', $multa);
    }

    return redirect()
        ->route('books.show', $borrowing->book_id)
        ->with('success', 'Livro devolvido com sucesso.');
}
    public function userBorrowings(User $user)
{
    $borrowings = $user->books()->withPivot('borrowed_at', 'returned_at')->get();

    return view('users.borrowings', compact('user', 'borrowings'));
}


}
