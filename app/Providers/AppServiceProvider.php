<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });

        if (app()->isProduction()) {
            URL::forceScheme('https');
        }

        Cashier::calculateTaxes();
        Model::shouldBeStrict(!$this->app->isProduction());

        Blade::directive('money', function ($expression) {
            [$amount, $currency] = explode(',', $expression);

            return "<?php echo formatCurrency($amount, $currency); ?>";
        });

        Blade::directive('datetime', static function ($expression) {
            $expression = str_replace(['(', ')', ' '], '', $expression);

            $args = explode(',', $expression);

            $dateTime = $args[0];

            $format = $args[1] ?? 'd/m/Y H:i';

            return "<?php echo (new \Carbon\Carbon($dateTime))->format('$format'); ?>";
        });

        Blade::directive('date', static function ($expression) {
            $expression = str_replace(['(', ')', ' '], '', $expression);

            $args = explode(',', $expression);

            $dateTime = $args[0];

            $format = $args[1] ?? 'd/m/Y';

            return "<?php echo (new \Carbon\Carbon($dateTime))->format('$format'); ?>";
        });

        Blade::directive('hour', static function ($expression) {
            $expression = str_replace(['(', ')', ' '], '', $expression);

            $dateTime = $expression;

            return "<?php echo (new \Carbon\Carbon($dateTime))->format('H:i'); ?>";
        });
    }
}
