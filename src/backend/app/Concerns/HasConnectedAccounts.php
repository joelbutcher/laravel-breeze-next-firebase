<?php

namespace App\Concerns;

use App\Models\ConnectedAccount;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property Collection<ConnectedAccount> $connectedAccounts
 * @mixin Model
 */
trait HasConnectedAccounts
{
    /**
     * @param  string  $uid
     * @param  string  $provider
     * @param  string  $providerId
     * @return ConnectedAccount|null
     */
    public function getConnectedAccountForUidAndProvider(string $uid, string $provider, string $providerId): ?ConnectedAccount
    {
        return $this->connectedAccounts
            ->where('uid', $uid)
            ->where('provider', '=', $provider)
            ->where('provider_id', '=', $providerId)
            ->first();
    }

    /**
     * @return HasMany
     */
    public function connectedAccounts(): HasMany
    {
        return $this->hasMany(ConnectedAccount::class, 'user_id');
    }
}
