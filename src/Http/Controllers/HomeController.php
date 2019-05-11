<?php

namespace shooteram\Auth\Http\Controllers;

class HomeController
{
    public function home()
    {
        $data = ['message' => 'Welcome home.'];

        return response()->json($data, 200);
    }
}
