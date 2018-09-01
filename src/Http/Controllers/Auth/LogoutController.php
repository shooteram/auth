<?php

namespace shooteram\Auth\Http\Controllers\Auth;

use Auth;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LogoutController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function logout()
    {
      Auth::logout();

      return response()->json('You\'ve successfully logged out.', 200);
    }
}
