<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function MemberDashboard(){
        return view('member.member_dashboard');
    }
}
