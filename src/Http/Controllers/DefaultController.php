<?php

namespace shooteram\Auth\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DefaultController extends Controller
{
    public function getCsrfToken()
    {
        return response()->json(null, 200);
    }
}
