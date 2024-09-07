<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LibrarianController extends Controller
{
    public function LibrarianDashboard(){
        return view('librarian.librarian_dashboard');
    }
}
