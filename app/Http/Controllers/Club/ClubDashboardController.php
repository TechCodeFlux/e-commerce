<?php

namespace App\Http\Controllers\Club;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClubDashboardController extends Controller
{
    public function index()
    {
        return view('club.dashboard');
    }

  
}
