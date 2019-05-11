<?php

namespace shooteram\Auth\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

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
        $userClass = config('auth.providers.users.model');
        $validationRules = config('cors.validation.register');
        $customUsername = config('cors.auth.login.username');

        $credentialsFields = $customUsername
            ? [$customUsername, 'password']
            : array_keys(config('cors.validation.login'));

        $credentials = $request->only($credentialsFields);

        $validator = Validator::make($request->all(), $validationRules);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        $only = array_keys($validationRules);

        $fields = collect($request->only($only))->merge([
            'password' => Hash::make($request->password),
        ]);

        $user = new $userClass;
        $user->fill($fields->all());
        $user->save();

        return response()->json(['token' => $user->createToken('Password grant')->accessToken]);
    }
}
