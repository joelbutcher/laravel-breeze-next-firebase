<?php

namespace App\Contracts\Repositories;

use Illuminate\Contracts\Auth\Authenticatable;
use Kreait\Firebase\Auth\UserRecord;

interface ConnectedAccountRepository
{
    /**
     * @param  UserRecord  $firebaseUser
     * @return Authenticatable|null
     */
    public function findForFirebase(UserRecord $firebaseUser): ?Authenticatable;
}
