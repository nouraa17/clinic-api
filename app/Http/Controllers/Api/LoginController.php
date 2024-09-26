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
        $credentials = $request->only(['email', 'password']);

        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            $user['token'] = $user->createToken($user->email, [$user->type])->plainTextToken;
            return Messages::success(UserResource::make($user), 'Logged in successfully');
        } else {
            return Messages::error('Login Failed');
        }
    }

}
