<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $uid
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $display_name
 * @property string|null $photo_url
 * @property string|null $provider
 * @property string|null $provider_id
 * @property bool|null $email_verified
 * @property \DateTimeInterface|CarbonInterface $created_at
 * @property \DateTimeInterface|CarbonInterface $updated_at
 * @property \DateTimeInterface|CarbonInterface $deleted_at
 * @property User $user
 */
class ConnectedAccount extends Model
{
    use HasFactory;

    /**
     * @var array<string>
     */
    protected $fillable = [
        'uid',
        'email',
        'phone',
        'display_name',
        'photo_url',
        'provider',
        'provider_id',
        'email_verified',
    ];

    public function id(): int
    {
        return $this->id;
    }

    public function uid(): string
    {
        return $this->uid;
    }

    public function email(): ?string
    {
        return $this->email;
    }

    public function phone(): ?string
    {
        return $this->phone;
    }

    public function displayName(): ?string
    {
        return $this->display_name;
    }

    public function photoUrl(): ?string
    {
        return $this->photo_url;
    }

    public function provider(): ?string
    {
        return $this->provider;
    }

    public function providerId(): ?string
    {
        return $this->provider_id;
    }

    public function isEmailVerified(): ?bool
    {
        return $this->email_verified;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
