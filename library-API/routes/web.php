<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LibrarianController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\AuthorController;

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


//All Author Route
Route::controller(AdminController::class)->group(function(){
    Route::get('/admin/dashboard', 'AdminDashboard')->name('admin.dashboard');
    Route::get('/all/admin', 'AllAdmin')->name('all.admin');
    Route::get('/add/admin' , 'AddAdmin')->name('add.admin');
    Route::post('/admin/user/store' , 'AdminUserStore')->name('admin.user.store');

    Route::get('/edit/admin/role/{id}' , 'EditAdminRole')->name('edit.admin.role');

    Route::post('/admin/user/update/{id}' , 'AdminUserUpdate')->name('admin.user.update');

    Route::get('/delete/admin/role/{id}' , 'DeleteAdminRole')->name('delete.admin.role');
});


//Retrieving Librarian User only
Route::get('librarian/dashboard', [LibrarianController::class, 'LibrarianDashboard'])->name('librarin.Dashboard');

//Retrieving Librarian User only
Route::get('member/dashboard', [MemberController::class, 'MemberDashboard'])->name('member.Dashboard');



//All Author Route
Route::controller(AuthorController::class)->group(function(){
    Route::get('/all/author', 'AllAuthor')->name('all.author');
});


