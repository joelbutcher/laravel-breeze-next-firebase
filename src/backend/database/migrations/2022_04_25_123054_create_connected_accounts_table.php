<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create('connected_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained(($user = new User)->getTable(),$user->getKeyName());
            $table->string('uid');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('photo_url')->nullable();
            $table->string('display_name')->nullable();
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();
            $table->boolean('email_verified')->nullable();
            $table->timestamps();
        });
    }
};
