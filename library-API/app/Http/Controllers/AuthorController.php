<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthorController extends Controller
{
    //Method for Displaying all authors
    public function AllAuthor(){
        $authors = Brand::latest()->get();
        return view('backend.author.author_all',compact(authors));
    } //End Method
}
