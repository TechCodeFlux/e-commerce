<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Required for password checking
use Illuminate\Support\Facades\Session; // Required for session management

class ClubController extends Controller
{
    public function clublogin()
    {
        return view('clublogin'); 
    }

    public function check(Request $request)
    {
        // 1. Validate the input
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // 2. Find the club by username ONLY
        $club = Club::where('username', $request->username)->first();

        // 3. Check if club exists AND password matches the hash
        if ($club && Hash::check($request->password, $club->password)) {
            
            // 4. Store data in session
            Session::put('club_id', $club->id);
            Session::put('club_name', $club->club_name); // Ensure 'club_name' is the correct column name

            return redirect('list');
        } else {
            // 5. Authentication failed - return with an error message
            return back()->with('fail', 'Invalid username or password');
        }
    }
}