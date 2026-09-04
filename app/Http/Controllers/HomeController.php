<?php

namespace App\Http\Controllers;

use App\Models\Billiard;
use App\Models\Rate;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $billiards = Billiard::count();
        $users = User::count();
        $rates = Rate::count();
        return view('content.pages.pages-home', [
                'billiards' => $billiards,
                'users' => $users,
                'rates' => $rates
            ]
        );
    }
}
