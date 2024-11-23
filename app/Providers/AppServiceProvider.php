<?php

namespace App\Providers;

use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
        $this->app->register(TelescopeServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
	if($this->app->environment('production')) {
	    \URL::forceScheme('https');
	}

        Paginator::useBootstrap();
        \Str::macro('snakeToTitle', function($value) {
            return \Str::title(str_replace('_', ' ', $value));
        });
        Builder::macro('whereLatestRelation', function ($table, $parentRelatedColumn)
        {
            return $this->where($table . '.id', function ($sub) use ($table, $parentRelatedColumn) {
                $sub->select('id')
                    ->from($table . ' AS other')
                    ->whereColumn('other.' . $parentRelatedColumn, $table . '.' . $parentRelatedColumn)
                    ->latest()
                    ->take(1);
            });
        });
    }
}
