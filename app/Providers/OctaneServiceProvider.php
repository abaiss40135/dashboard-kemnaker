<?php

namespace App\Providers;

use Detection\MobileDetect;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class OctaneServiceProvider extends ServiceProvider
{
    private $isRunningInOctane;

    public function register()
    {
        parent::register();

        $this->registerBinding('agent', fn (Application $app) => new MobileDetect($app['request']->server()), MobileDetect::class);
    }

    private function registerBinding(string $name, callable $fn, string $alias): void
    {
        if ($this->runningInOctane()) {
            $this->app->bind($name, $fn, true);
        } else {
            $this->app->singleton($name, $fn);
        }

        $this->app->alias($name, $alias);
    }

    private function runningInOctane(): bool
    {
        if (is_null($this->isRunningInOctane)) {
            $this->isRunningInOctane = !$this->app->runningInConsole() && config('octane.start');
        }

        return $this->isRunningInOctane;
    }
}
