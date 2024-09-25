<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserFormRequest;
use App\Models\User;
use App\Repositories\Auth\RegisterRepository;
use App\Services\Messages;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */

    private $repo;

    public function __construct(RegisterRepository $repo) //injecting the class to create instance
    {
        $this->repo = $repo;

    }
    public function __invoke(UserFormRequest $request)
    {
        return $this->repo->create_user($request->validated());


    }
}
