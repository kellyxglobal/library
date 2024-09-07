<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;

class BookController extends Controller
{
    //Method for Displaying all books
    public function AllBook(){
        $books = Book::latest()->get();
        return view('books.all_book',compact('books'));
    } //End Method

    //Method for Adding New Book for specific authors
    public function AddBook(){
        $author = Author::orderBy('name', 'ASC')->get();
        return view('books.add_book',compact('author'));
    } //End Method

    //Method for storing/saving new books
    public function SaveBook(Request $request){
        Book::insert([
            'author_id' => $request->author_id,
            'title' => $request->title,
            'isbn' => $request->isbn,
            'status' => $request->status,
        ]);
        return redirect()->route('books.all_book');

    } //End Method


    //Method for Editing A specific Book
    public function EditBook($id){
        $book = Book::findOrFail($id);
        return view('books.book_edit',compact('book'));
    }// End Method 


    //Method for updating edited users
    public function UpdateBook(Request $request){

        $book_id = $request->id;

        Book::findOrFail($book_id)->update([
            'author_id' => $request->author_id,
            'title' => $request->title,
            'isbn' => $request->isbn,
            'status' => $request->status,


        ]);
        return redirect()->route('books.all_book');

    }

    //Method for deleting a specific user
    public function DeleteBook($id){
        Book::findOrFail($id)->delete();
        return redirect()->back();

    }//End Method


}
