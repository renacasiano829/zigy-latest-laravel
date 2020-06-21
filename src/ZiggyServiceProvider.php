<?php

namespace Tightenco\Ziggy;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

class ZiggyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Route::macro('except', function ($group = null) {
            return Macro::except($this, $group);
        });

        Route::macro('only', function ($group = null) {
            return Macro::only($this, $group);
        });

        if ($this->app->resolved('blade.compiler')) {
            $this->registerDirective($this->app['blade.compiler']);
        } else {
            $this->app->afterResolving('blade.compiler', function (BladeCompiler $bladeCompiler) {
                $this->registerDirective($bladeCompiler);
            });
        }

        if ($this->app->runningInConsole()) {
            $this->commands([
                CommandRouteGenerator::class,
            ]);
        }
    }

    protected function registerDirective(BladeCompiler $bladeCompiler)
    {
        $bladeCompiler->directive('routes', function ($group) {
            return "<?php echo app('" . BladeRouteGenerator::class . "')->generate({$group}); ?>";
        });
    }
}
