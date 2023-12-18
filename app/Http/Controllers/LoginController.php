<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function login(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first;
        if ($user && Hash::check($request->input('password'), $user->password))
        {
            $apikey = base64_encode(Str::random(40));
            $user["api_token"] = $apikey;
            $user->save();
            return response()->json(['status' => 'Login success',
                'result' => $apikey], 200);
        }
        else
        {
            return response()->json(['status' => 'Login fail'], 400);
        }
    }
}
