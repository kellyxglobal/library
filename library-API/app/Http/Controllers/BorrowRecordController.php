<?php

namespace App\Http\Controllers;
use App\Models\Book;
use App\Models\BorrowRecord;

use Illuminate\Http\Request;

class BorrowRecordController extends Controller
{
    public function borrowBook(Book $book)
    {
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
}
