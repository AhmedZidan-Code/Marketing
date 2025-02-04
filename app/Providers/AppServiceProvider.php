<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Register macro for Query Builder
        QueryBuilder::macro('applyBranchCondition', function () {
            $user = Auth::guard('admin')->user();
            if ($user && $user->branch_id !== null) {
                $this->where('branch_id', $user->branch_id);
            }
            return $this;
        });

        // Register macro for Eloquent Builder
        EloquentBuilder::macro('applyBranchCondition', function () {
            $user = Auth::guard('admin')->user();
            if ($user && $user->branch_id !== null) {
                $this->where($this->getModel()->getTable() . '.branch_id', $user->branch_id);
            }
            return $this;
        });

        view()->share('settings', Setting::firstOrCreate());

        Blade::if('canAdminAny', function (...$permissions) {
            $user = auth('admin')->user();
            foreach ($permissions as $permission) {
                if ($user->can($permission)) {
                    return true;
                }
            }
            return false;
        });
    }
}
