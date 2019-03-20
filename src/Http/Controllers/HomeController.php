<?php

namespace shooteram\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function home()
    {
        $data = ['message' => 'Welcome home.'];

        if (Auth::Check()) {
            $data = array_merge($data, ['you' => Auth::user()]);
        }

        return response()->json($data, 200);
    }
}
