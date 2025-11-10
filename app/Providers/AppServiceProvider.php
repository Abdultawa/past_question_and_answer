<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Services\MbashirService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('mbashir', function ($app) {
            return new MbashirService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Model::unguard();

        Gate::define('admin', function (User $user) {
            return $user->email === 'admin@gmail.com';
        });

        Blade::if('admin', function () {
            return request()->user()?->can('admin');
        });
    }
}
