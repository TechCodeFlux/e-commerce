<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function create()
    {
        return view('admin.clubf');
    }

    public function adnew()
    {
        return view('admin.anadmin');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:admins,email',
            'dob'     => 'required|date',
            'gender'  => 'required|in:Male,Female,Other',
            'address' => 'required|string',
            'contact' => 'required|string|max:15',
        ]);

        return redirect()->route('dashboard.create')->with('success', 'Admin added successfully!');
    }
}
