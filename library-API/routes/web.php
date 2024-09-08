<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LibrarianController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowRecordController;
use App\Http\Controllers\RoleController;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::controller(RoleController::class)->group(function(){
    Route::get('/all/permission','AllPermission')->name('all.permission');
});

Route::controller(RoleController::class)->group(function(){
    Route::get('/all/roles','Role')->name('all.roles');
});

//All Admin Route Middleware
Route::middleware(['auth','role:Admin'])->group(function() {
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/all/admin', [AdminController::class, 'AllAdmin'])->name('all.admin');
    Route::get('/add/admin', [AdminController::class, 'AddAdmin'])->name('add.admin');
    Route::get('/admin/user/store', [AdminController::class, 'AdminUserStore'])->name('admin.user.store');
    Route::get('/edit/admin/{id}', [AdminController::class, 'EditAdmin'])->name('edit.admin');
    Route::get('/admin/user/update/{id}', [AdminController::class, 'AdminUserUpdate'])->name('admin.user.update');
    Route::get('/delete/admin/{id}', [AdminController::class, 'DeleteAdminRole'])->name('delete.admin');


//Admin All Book Route
Route::controller(BookController::class)->group(function(){
    Route::get('/books', 'index')->name('books.index');
    Route::get('/books', 'pagination')->name('books.pagination');
    Route::get('/books/{id}', 'show')->name('books.show');
    Route::post('/books', 'store')->name('books.store');
    Route::put('/books/{id}', 'update')->name('books.update');
    Route::delete('/books/{id}', 'destroy')->name('books.destroy');
    Route::get('/books/search', 'search')->name('books.search');

});//End Admin Book Route

//All Author Route
Route::controller(AuthorController::class)->group(function(){
    Route::get('/authors', 'index')->name('authors.index');
    Route::get('/authors', 'pagination')->name('authors.pagination');
    Route::get('/authors/{id}', 'show')->name('authors.show');
    Route::post('/authors', 'store')->name('authors.store');
    Route::put('/authors/{id}', 'update')->name('authors.update');
    Route::delete('/authors/{id}', 'destroy')->name('authors.destroy');
});

// All BorrowRecordController route for admin
Route::controller(BorrowRecordController::class)->group(function() {
    Route::get('/borrow-records', 'index')->name('borrow-records.index');
    Route::get('/borrow-records', 'pagination')->name('borrow-records.index');
    Route::get('/borrow-records/{id}', 'show')->name('borrow-records.show');
});//End Borrow route for admin

});//End Admin group middleware



Route::middleware(['auth','role:Librarian'])->group(function() {
//All Route For Retrieving Librarian User only
Route::get('/librarian/dashboard', [LibrarianController::class, 'LibrarianDashboard'])->name('librarian.dashboard');


//All Book Route
Route::controller(BookController::class)->group(function(){
    Route::get('/books', 'index')->name('books.index');
    Route::get('/books', 'pagination')->name('books.pagination');
    Route::get('/books/{id}', 'show')->name('books.show');
    Route::post('/books', 'store')->name('books.store');
    Route::put('/books/{id}', 'update')->name('books.update');
    Route::delete('/books/{id}', 'destroy')->name('books.destroy');
    Route::get('/books/search', 'search')->name('books.search');

});//End Book route for librarian

//All Author Route for librarian
Route::controller(AuthorController::class)->group(function(){
    Route::get('/authors', 'index')->name('authors.index');
    Route::get('/authors', 'pagination')->name('authors.pagination');
    Route::get('/authors/{id}', 'show')->name('authors.show');
    Route::post('/authors', 'store')->name('authors.store');
    Route::put('/authors/{id}', 'update')->name('authors.update');
    Route::delete('/authors/{id}', 'destroy')->name('authors.destroy');
});//End Author route librarian

//BorrowRecordController route for Librarian
Route::controller(BorrowRecordController::class)->group(function() {
    Route::get('/borrow-records', 'index')->name('borrow-records.index');
    Route::get('/borrow-records', 'pagination')->name('borrow-records.pagination');
    Route::get('/borrow-records/{id}', 'show')->name('borrow-records.show');
});//End Borrow route for librarian

});//End Librarian group middleware


//All Route For Retrieving Member User only
Route::middleware(['auth', 'role:Member'])->group(function() {
    Route::controller(BorrowRecordController::class)->group(function(){
        Route::post('/books/{id}/borrow', 'BorrowBook')->name('borrowBook');
        Route::post('/books/{id}/return', 'ReturnBook')->name('returnBook');
    });

    //Implemebting Search functonality
    Route::controller(BookController::class)->group(function(){
        Route::get('/books/search', 'search')->name('books.search');

    });
});


