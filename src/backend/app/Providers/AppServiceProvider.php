<?php

namespace App\Providers;

use App\Actions\Auth\CreateConnectedAccount;
use App\Actions\Auth\CreateNewUser;
use App\Contracts\Auth\CreatesConnectedAccounts;
use App\Contracts\Auth\CreatesNewUsers;
use App\Contracts\Repositories\UserRepository as UserRepositoryContract;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->registerActions();
        $this->registerRepositories();
    }

    /**
     * @return void
     */
    public function boot(): void
    {
        //
    }

    /**
     * @return void
     */
    protected function registerActions(): void
    {
        $this->app->bind(CreatesNewUsers::class, fn ($app) => $app[CreateNewUser::class]);
        $this->app->bind(CreatesConnectedAccounts::class, fn ($app) => $app[CreateConnectedAccount::class]);
    }

    /**
     * @return void
     */
    protected function registerRepositories(): void
    {
        $this->app->bind(UserRepositoryContract::class, fn ($app) => $app[UserRepository::class]);
    }
}
