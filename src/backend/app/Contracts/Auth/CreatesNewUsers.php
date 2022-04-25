<?php

namespace App\Contracts\Auth;

use Illuminate\Contracts\Auth\Authenticatable;
use Kreait\Firebase\Auth\UserRecord;
use Lcobucci\JWT\UnencryptedToken;

interface CreatesNewUsers
{
    /**
     * @param  UserRecord  $user
     * @return Authenticatable
     */
    public function create(UserRecord $firebaseUser): Authenticatable;

    /**
     * @param  UnencryptedToken  $token
     * @return Authenticatable
     */
    public function createFromToken(UnencryptedToken $token): Authenticatable;
}
