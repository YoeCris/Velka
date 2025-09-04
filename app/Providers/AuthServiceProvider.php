<?php

namespace App\Providers;

use App\Models\Comunero;
use App\Models\Reunion;
use App\Policies\ComuneroPolicy;
use App\Policies\ReunionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Comunero::class => ComuneroPolicy::class,
        Reunion::class => ReunionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
