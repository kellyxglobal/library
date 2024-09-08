<?php

namespace App\Http\Controllers;
use App\Models\Book;
use App\Models\BorrowRecord;

use Illuminate\Http\Request;

class BorrowRecordController extends Controller {
    public function index(){
        $borrowRecords = BorrowRecord::all();
        return response()->json($borrowRecords, 200); // Return all borrow records (Admin/Librarian only)
    }

    // Route model binding
    public function show(BorrowRecord $borrowRecord) {
        return response()->json($borrowRecord, 200); // Return a specific borrow record (Admin/Librarian only)
    }

    public function BorrowBook(Book $book){
        // Check if the book is available
        if ($book->status !== 'Available') {
            return response()->json(['error' => 'Book is not available for borrowing'], 400);
        }

        // Create a new borrow record
        $borrowRecord = new BorrowRecord();
        $borrowRecord->user_id = auth()->user()->id;
        $borrowRecord->book_id = $book->id;
        $borrowRecord->borrowed_at = now();
        $borrowRecord->due_at = now()->addDays(14); // Adjust the due date as needed
        $borrowRecord->save();

        // Update the book status
        $book->status = 'Borrowed';
        $book->save();

        return response()->json(['message' => 'Book borrowed successfully']);
    }


    public function ReturnBook(Book $book)
{
    // Find the existing borrow record for the authenticated user and the given book
    $borrowRecord = BorrowRecord::where('user_id', auth()->user()->id)
        ->where('book_id', $book->id)
        ->whereNull('returned_at')
        ->first();

    if (!$borrowRecord) {
        return response()->json(['error' => 'You have not borrowed this book'], 400);
    }

    // Update the borrow record
    $borrowRecord->returned_at = now();
    $borrowRecord->save();

    // Update the book status
    $book->status = 'Available';
    $book->save();

    return response()->json(['message' => 'Book returned successfully']);
}

//Implementing Pagination Functionality
public function pagination(Request $request){
    $perPage = $request->input('per_page', 10);
    $page = $request->input('page', 1);
    $borrowrecords = BorrowRecord::paginate($perPage, ['*'], 'page', $page);
    return response()->json($borrowrecords);
}
}
