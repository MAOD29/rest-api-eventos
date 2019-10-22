<?php

namespace App\Providers;
use App\User;
use App\Business;
use App\Event;
use App\Spot;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Business::class => UserPolicy::class,
        Event::class => UserPolicy::class,
        Spot::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {

         $this->registerPolicies();
        Passport::routes();
        Passport::tokensExpireIn(now()->addDays(15));

        Passport::refreshTokensExpireIn(now()->addDays(30));
    
        Passport::personalAccessTokensExpireIn(now()->addMonths(6));
    }
}
