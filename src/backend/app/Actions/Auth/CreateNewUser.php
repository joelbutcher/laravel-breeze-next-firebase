<?php

namespace App\Actions\Auth;

use App\Contracts\Auth\CreatesConnectedAccounts;
use App\Contracts\Auth\CreatesNewUsers;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Kreait\Firebase\Auth\UserRecord;
use Kreait\Firebase\Contract\Auth;
use Lcobucci\JWT\UnencryptedToken;

class CreateNewUser implements CreatesNewUsers
{
    /**
     * @param  Auth  $firebaseAuth
     */
    public function __construct(
        protected Auth $firebaseAuth,
        protected CreatesConnectedAccounts $createsConnectedAccounts,
    ) { }

    /**
     * @param  UserRecord  $user
     * @return Authenticatable
     */
    public function create(UserRecord $firebaseUser): Authenticatable
    {
        return DB::transaction(fn () => tap(User::create([
            'name' => $firebaseUser->displayName,
            'email' => Arr::first($firebaseUser->providerData)?->email,
            'email_verified' => $firebaseUser->emailVerified,
        ]), fn (User $user) => $this->createsConnectedAccounts->create($user, $firebaseUser)));
    }

    /**
     * @param  UnencryptedToken  $token
     * @return Authenticatable
     * @throws \Kreait\Firebase\Exception\AuthException
     * @throws \Kreait\Firebase\Exception\FirebaseException
     */
    public function createFromToken(UnencryptedToken $token): Authenticatable
    {
        return $this->create($this->firebaseAuth->getUser($token->claims()->get('uid')));
    }
}
