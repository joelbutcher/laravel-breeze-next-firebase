<?php

namespace App\Repositories;

use App\Contracts\Repositories\UserRepository as UserRepositoryContract;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

class UserRepository implements UserRepositoryContract
{
    /**
     * @param  string  $email
     * @return Authenticatable|null
     */
    public function findOneForEmail(string $email): ?Authenticatable
    {
        return User::query()
            ->where('email', '=', $email)
            ->first();
    }
}
