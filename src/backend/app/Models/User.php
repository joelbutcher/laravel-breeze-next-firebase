<?php

namespace App\Models;

use App\Concerns\HasConnectedAccounts;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string|null $display_name
 * @property string $email
 * @property \DateTimeInterface|CarbonInterface $created_at
 * @property \DateTimeInterface|CarbonInterface $updated_at
 * @property \DateTimeInterface|CarbonInterface $deleted_at
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasConnectedAccounts;
    use HasFactory;
    use Notifiable;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'display_name',
        'email',
    ];

    /**
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];
}
