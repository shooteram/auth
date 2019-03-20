<?php

namespace shooteram\Auth\Http\Controllers\Auth;

use Auth;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function register(Request $request)
    {
        $user_class = config('auth.providers.users.model');
        $validation_rules = config('cors.validation.register');

        $validator = Validator::make($request->all(), $validation_rules);

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()->first()], 400);

        $only = array_keys($validation_rules);

        $fields = collect($request->only($only))
            ->merge(['password' => Hash::make($request->password)]);

        $user = new $user_class;
        $user->fill($fields->all());
        $user->save();

        Auth::login($user, true);

        return response()->json($user, 200);
    }
}
