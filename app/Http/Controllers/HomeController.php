<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rpg;

class HomeController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }

        return view('home');
    }
}
