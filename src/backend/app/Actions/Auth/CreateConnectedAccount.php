<?php

namespace App\Actions\Auth;

use App\Contracts\Auth\CreatesConnectedAccounts;
use App\Models\ConnectedAccount;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Arr;
use Kreait\Firebase\Auth\UserRecord;

class CreateConnectedAccount implements CreatesConnectedAccounts
{
    /**
     * @param  Authenticatable  $user
     * @param  UserRecord  $firebaseUser
     * @return ConnectedAccount
     */
    public function create(Authenticatable $user, UserRecord $firebaseUser): ConnectedAccount
    {
        $providerData = Arr::first($firebaseUser->providerData);
        return $user->connectedAccounts()->create([
            'uid' => $firebaseUser->uid,
            'email' => $providerData->email,
            'phone' => $firebaseUser->phoneNumber,
            'display_name' => $providerData?->displayName,
            'photo_url' => $providerData?->photoUrl,
            'provider' => $providerData?->providerId,
            'provider_id' => $providerData?->uid,
            'email_verified' => $firebaseUser->emailVerified,
        ]);
    }
}
