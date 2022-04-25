<?php

namespace App\Contracts\Repositories;

use Illuminate\Contracts\Auth\Authenticatable;

interface UserRepository extends Repository
{
    /**
     * @param  string  $email
     * @return Authenticatable|null
     */
    public function findOneForEmail(string $email): ?Authenticatable;
}
