<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function welcome()
    {
        $categories = Category::take(8)->get();
        return view('welcome', compact('categories'));
    }

    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }


    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function resetPassword(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function dashboard()
    {
        return view('dashboard.index');
    }


    public function mentorDashboard()
    {
        return view('dashboard.mentor');
    }

    public function mentors()
    {
        return view('mentors.index');
    }

    public function mentorShow($uuid)
    {
        return view('mentors.show', compact('uuid'));
    }

    public function categories()
    {
        return view('categories.index');
    }

    public function categoryShow($slug)
    {
        return view('categories.show', compact('slug'));
    }

    public function bookings()
    {
        return view('bookings.index');
    }

    public function logout(Request $request)
    {
        return redirect()->route('home');
    }

}
