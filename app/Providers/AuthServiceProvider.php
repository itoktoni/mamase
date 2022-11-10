<?php

namespace App\Providers;

use App\Dao\Enums\RoleType;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Plugins\Template;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        try {
            // Template::routes();
        } catch (\Throwable $th) {
            abort('500', $th->getMessage());
        }

        Auth::provider('cache-user', function() {
            return resolve(CacheableAuthUserServiceProvider::class);
        });

        // https://devdojo.com/tnylea/laravel-gates
        // https://medium.com/dotlocal/belajar-laravel-tutorial-menggunakan-authorization-dengan-gates-2130069bb6d2

        Gate::define('isAdmin', function($user) {
            return $user->type == RoleType::Admin;
         });
         Gate::define('isPelaksana', function($user) {
             return $user->type == RoleType::Pelaksana;
         });
         Gate::define('isPengawas', function($user) {
             return $user->type == RoleType::Pengawas;
         });
         Gate::define('isUser', function ($user) {
             return $user->type === RoleType::User;
         });
    }
}
