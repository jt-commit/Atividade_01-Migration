<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Rotas para todos os usuários autenticados
| (Clientes, Bibliotecários e Administradores)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Visualização
    Route::resource('books', BookController::class)
        ->only(['index', 'show']);

    Route::resource('authors', AuthorController::class)
        ->only(['index', 'show']);

    Route::resource('categories', CategoryController::class)
        ->only(['index', 'show']);

    Route::resource('publishers', PublisherController::class)
        ->only(['index', 'show']);

    // Histórico de empréstimos do usuário
    Route::get('/users/{user}/borrowings',
        [BorrowingController::class, 'userBorrowings'])
        ->name('users.borrowings');
});

/*
|--------------------------------------------------------------------------
| Rotas para Admin e Bibliotecário
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,bibliotecario'])->group(function () {

    // Livros
    Route::get('/books/create-id-number',
        [BookController::class, 'createWithId'])
        ->name('books.create.id');

    Route::post('/books/create-id-number',
        [BookController::class, 'storeWithId'])
        ->name('books.store.id');

    Route::get('/books/create-select',
        [BookController::class, 'createWithSelect'])
        ->name('books.create.select');

    Route::post('/books/create-select',
        [BookController::class, 'storeWithSelect'])
        ->name('books.store.select');

    Route::resource('books', BookController::class)
        ->except(['index', 'show']);

    // Autores
    Route::resource('authors', AuthorController::class)
        ->except(['index', 'show']);

    // Categorias
    Route::resource('categories', CategoryController::class)
        ->except(['index', 'show']);

    // Editoras
    Route::resource('publishers', PublisherController::class)
        ->except(['index', 'show']);

    // Empréstimos
    Route::post('/books/{book}/borrow',
        [BorrowingController::class, 'store'])
        ->name('books.borrow');

    Route::patch('/borrowings/{borrowing}/return',
        [BorrowingController::class, 'returnBook'])
        ->name('borrowings.return');
});

/*
|--------------------------------------------------------------------------
| Rotas somente para Administrador
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::resource('users', UserController::class);

});



/*ROTA PARA QUITAR DEBITO*/ 
Route::patch(
    '/users/{user}/pay-debt',
    [UserController::class,'payDebt']
)->name('users.payDebt');