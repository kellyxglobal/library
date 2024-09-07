<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LibrarianController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowRecordController;

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


//All Admin Route
Route::controller(AdminController::class)->group(function(){
    Route::get('/admin/dashboard', 'AdminDashboard')->name('admin.dashboard');
    Route::get('/all/admin', 'AllAdmin')->name('all.admin');
    Route::get('/add/admin' , 'AddAdmin')->name('add.admin');
    Route::post('/admin/user/store' , 'AdminUserStore')->name('admin.user.store');

    Route::get('/edit/admin/role/{id}' , 'EditAdminRole')->name('edit.admin.role');

    Route::post('/admin/user/update/{id}' , 'AdminUserUpdate')->name('admin.user.update');

    Route::get('/delete/admin/role/{id}' , 'DeleteAdminRole')->name('delete.admin.role');
});



//All Book Route
Route::controller(BookController::class)->group(function(){
    Route::get('/all/books', 'AllBook')->name('all.books');
    Route::get('/add/book', 'AddBook')->name('add.book');
    Route::post('/save/book' , 'SaveBook')->name('save.book');

    Route::get('/edit/book/{id}' , 'EditBook')->name('edit.book');

    Route::post('/book/update/{id}' , 'UpdateBook')->name('admin.book.update');

    Route::get('/delete/book/{id}' , 'DeleteBook')->name('delete.book');

    Route::post('/books/{id}/borrow', 'BorrowBook')-name('borrowBook');
    Route::post('/books/{id}/return', 'returnBook')-name('returnBook');

});

//All Author Route
Route::controller(AuthorController::class)->group(function(){
    Route::get('/all/author', 'AllAuthor')->name('all.author');
});

//All Route For Retrieving Librarian User only
Route::controller(LibrarianController::class)->group(function(){
    Route::get('librarian/dashboard', 'LibrarianDashboard')->name('librarin.Dashboard');

}); 

//All Route For Retrieving Member User only
Route::controller(MemberController::class)->group(function(){
    Route::get('member/dashboard', 'MemberController')->name('member.Dashboard');

}); 


