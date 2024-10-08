<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use Illuminate\Support\Facades\Validator; // For validation

class AuthorController extends Controller
{
    public function index(){
        $authors = Author::all();
        return response()->json($authors, 200); // Return all authors
    }

    // Route model binding for specific author
    public function show(Author $author) {
        return response()->json($author, 200); // Return a specific author
    }// Route model binding for specific author ends

    // Route model binding for specific author
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'birthdate' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $author = Author::create($request->all());
        return response()->json($author, 201); // Created
    }

    // Route model binding for updating Authors
    public function update(Request $request, Author $author) 
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'birthdate' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $author->update($request->all());
        return response()->json($author, 200); // OK
    }// Route model binding for updating Authors ends

    // Route model binding for deleting an author
    public function destroy(Author $author) {
        $author->delete();
        return response()->json(null, 204); // No Content
    }// Route model binding ends


    //Implementing Pagination Functionality
public function pagination(Request $request){
    $perPage = $request->input('per_page', 10);
    $page = $request->input('page', 1);
    $authors = Author::paginate($perPage, ['*'], 'page', $page);
    return response()->json($authors);
}
}
