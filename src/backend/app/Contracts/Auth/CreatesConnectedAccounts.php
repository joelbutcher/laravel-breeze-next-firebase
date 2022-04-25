<?php

namespace App\Contracts\Auth;

use App\Models\ConnectedAccount;
use Illuminate\Contracts\Auth\Authenticatable;
use Kreait\Firebase\Auth\UserRecord;

interface CreatesConnectedAccounts
{
    /**
     * @param  Authenticatable  $user
     * @param  UserRecord  $firebaseUser
     * @return ConnectedAccount
     */
    public function create(Authenticatable $user, UserRecord $firebaseUser): ConnectedAccount;
}
