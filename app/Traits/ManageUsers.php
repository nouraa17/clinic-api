<?php

namespace App\Traits;

use App\Filter\EndDateFilter;
use App\Filter\NameFilter;
use App\Filter\StartDateFilter;
use App\Filter\TypeFilter;
use App\Filter\UserIdFilter;
use App\Http\Requests\UserFormRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\Messages;
use Illuminate\Pipeline\Pipeline;

trait ManageUsers
{
    // users management
    public function usersIndex()
    {
        $data = User::query();
        $users = app(Pipeline::class)
            ->send($data)
            ->through([
                NameFilter::class,
                UserIdFilter::class,
                TypeFilter::class,
                StartDateFilter::class,
                EndDateFilter::class,
            ])
            ->thenReturn()
            ->get();
        return UserResource::collection($users);
    }
    public function storeUser(UserFormRequest $request)
    {
        return $this->repo->create_user($request->validated());

    }
    public function showUser($id)
    {
        $user = User::query()->where('id',$id)->IfNotFound();
        return UserResource::make($user);
    }
    public function updateUser(UserFormRequest $request, string $id)
    {
        $data = $request->validated();
        $user = User::query()->where('id',$id)->IfNotFound();
        $user->update($data);
        return Messages::success(UserResource::make($user), 'User updated successfully');
    }
    public function deleteUser(string $id)
    {
        $user = User::query()->where('id',$id)->IfNotFound();
        $user->delete();
        return Messages::success(UserResource::make($user),'User deleted successfully');
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////


}
