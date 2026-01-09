<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SampleController extends Controller
{
       
    public function store(Request $request)
{
    // $username = $request->username;
    // $password = $request->password;
    // if ($username === 'admin' && $password === '123') {
    //     return view('displayuser', compact('username', 'password'))->with('success', 'Login successful');
    // } else {
    //     return redirect('insert')->with('error', 'Login failed');
    // }
    return view('admin.form');
}
}


