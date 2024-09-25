<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserFormRequest;
use App\Http\Resources\UserResource;
use App\Services\Messages;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UserFormRequest $request)
    {
        $credentials = ['email' => request('email'), 'password' => request('password')];
        if (auth()->attempt($credentials)) {
            $data = auth()->user();
            $data['token'] = auth()->user()->createToken($data['email'])->plainTextToken;
            return Messages::success(UserResource::make($data),'Logged in successfully');
        }
        else{
            return Messages::error('Login Failed');
        }
    }
}
