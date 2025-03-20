<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // echo "AAAAAAAAAAAAA";
        // exit;

        return redirect('/auth/login'); // Redirect to the desired location after logout
    }
}
