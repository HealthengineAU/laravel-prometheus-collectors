<?php
namespace HealthEngine\Prometheus;

use HealthEngine\Prometheus\Collector\QueueCollector;
use Illuminate\Support\ServiceProvider;
use Superbalist\LaravelPrometheusExporter\PrometheusExporter;

class PrometheusServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/prometheus-collectors.php' => config_path('prometheus-collectors.php'),
        ]);
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/prometheus-collectors.php', 'prometheus-collectors');

        $this->app->when(QueueCollector::class)
            ->needs('$queues')
            ->give(config('prometheus-collectors.queues'));

        $this->app->extend(PrometheusExporter::class, function (PrometheusExporter $exporter) {
            $exporter->registerCollector($this->app->make(QueueCollector::class));
            return $exporter;
        });
    }
}
