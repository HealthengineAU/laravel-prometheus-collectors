> [!WARNING]
> This package is abandoned, you should avoid using it.
>
> Use [spatie/laravel-prometheus](https://github.com/spatie/laravel-prometheus) instead.

# Laravel Prometheus Collectors

This package provides a set of default Prometheus data collectors for use with Laravel.

It includes a collector for metrics about:

- queue lengths

It only registers collectors which integrate into
[HealthEngineAU/laravel-prometheus-exporter](https://github.com/HealthEngineAU/laravel-prometheus-exporter).

## Usage

This extends the [HealthEngineAU/laravel-prometheus-exporter](https://github.com/HealthEngineAU/laravel-prometheus-exporter)
so you will need to read that documentation as well.

To customise what metrics are exported, publish the configuration file and edit it:

```bash
php artisan vendor:publish --provider="HealthEngine\Prometheus\PrometheusServiceProvider"
```

## License

Laravel Prometheus Collectors is licensed under the MIT license.
