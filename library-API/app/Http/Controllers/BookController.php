<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    //Method for Displaying all books
    public function index(){
        $books = Book::all();
        return response()->json($books, 200); // Return all books
        //return view('books.all_book',compact('books'));
    }//End Method

    //Method for Editing A specific Book
    public function show(Book $book) // Route model binding
    {
        return response()->json($book, 200); // Return a specific book
    }// End Method OR
    /*public function show($id){
        $book = Book::findOrFail($id);
        return view('books.book_edit',compact('book'));
    }// End Method */

    //Method for Adding New Book for specific authors
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255', // Replace with your validation rules
            'isbn' => 'required|string|unique:books|max:13',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422); // Unprocessable Entity
        }

        $book = Book::create($request->all());
        return response()->json($book, 201); // Created
    }



    // Route model binding
    public function update(Request $request, Book $book){
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255', // Replace with your validation rules
            'isbn' => 'required|string|unique:books,isbn,' . $book->id . ',id|max:13',
            // ... other validation rules
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422); // Unprocessable Entity
        }

        $book->update($request->all());
        return response()->json($book, 200); // OK
    }

    /*//Method for storing/saving new books
    public function SaveBook(Request $request){
        Book::insert([
            'author_id' => $request->author_id,
            'title' => $request->title,
            'isbn' => $request->isbn,
            'status' => $request->status,
        ]);
        return redirect()->route('books.all_book');

    } //End Method*/


    // Route model binding
    public function destroy(Book $book){
        $book->delete();
        return response()->json(null, 204); // No Content
    }

    /*//Method for deleting a specific user
    public function DeleteBook($id){
        Book::findOrFail($id)->delete();
        return redirect()->back();

    }//End Method*/


}
