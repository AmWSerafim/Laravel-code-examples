<?php

namespace App\Providers;

use App\Models\Permission;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class PermissionsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        try {
            Permission::get()->map(function ($permission) {
                Gate::define($permission->slug, function ($user) use ($permission) {
                    return $user->hasPermissionTo($permission);
                });
            });
        } catch (\Exception $e) {
            report($e);
            return false;
        }

        //Blade directives
        Blade::directive('role', function ($role) {
            return "<?php if(auth()->check() && auth()->user()->hasRole({$role})) : ?>"; //return this if statement inside php tag
        });

        Blade::directive('endrole', function ($role) {
            return "<?php endif; ?>"; //return this endif statement inside php tag
        });

        Blade::directive('user_can', function ($permission) {
            return "<?php if(auth()->check() && auth()->user()->can({$permission})): ?>"; //return this if statement inside php tag
            //return "if(auth()->check() && auth()->user()->can({$permission})):"; //return this if statement inside php tag
        });

        Blade::directive('end_user_can', function ($permission) {
            return "<?php endif; ?>"; //return this endif statement inside php tag
            //return "endif;"; //return this endif statement inside php tag
        });
    }
}
