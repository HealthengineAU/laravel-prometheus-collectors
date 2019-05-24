# Laravel Prometheus Collectors

[![Latest Stable Version](https://poser.pugx.org/healthengine/laravel-prometheus-collectors/version)](https://packagist.org/packages/healthengine/laravel-prometheus-collectors)
[![Total Downloads](https://poser.pugx.org/healthengine/laravel-prometheus-collectors/downloads)](https://packagist.org/packages/healthengine/laravel-prometheus-collectors)
[![Build Status](https://travis-ci.com/HealthEngineAU/laravel-prometheus-collectors.svg?branch=master)](https://travis-ci.com/HealthEngineAU/laravel-prometheus-collectors)
[![Coverage Status](https://coveralls.io/repos/github/HealthEngineAU/laravel-prometheus-collectors/badge.svg?branch=master)](https://coveralls.io/github/HealthEngineAU/laravel-prometheus-collectors?branch=master)
[![Dependabot Status](https://api.dependabot.com/badges/status?host=github&repo=HealthEngineAU/laravel-prometheus-collectors)](https://dependabot.com)

This package provides a set of default Prometheus data collectors for use with Laravel.

It includes a collector for metrics about:

- queue lengths

It only registers collectors which integrate into
[Superbalist/laravel-prometheus-exporter](https://github.com/Superbalist/laravel-prometheus-exporter).

## Usage

This extends the [Superbalist/laravel-prometheus-exporter](https://github.com/Superbalist/laravel-prometheus-exporter)
so you will need to read that documentation as well.

To customise what metrics are exported, publish the configuration file and edit it:

```bash
php artisan vendor:publish --provider="HealthEngine\Prometheus\PrometheusServiceProvider"
```

## License

Laravel Prometheus Collectors is licensed under the MIT license.
