<?php

declare(strict_types=1);

namespace Tests;

use Healthengine\LaravelPrometheusExporter\PrometheusExporter;
use Healthengine\LaravelPrometheusExporter\PrometheusServiceProvider as PrometheusExporterServiceProvider;
use Healthengine\Prometheus\Collector\QueueCollector;
use Healthengine\Prometheus\PrometheusServiceProvider;
use Orchestra\Testbench\TestCase;

/**
 * @covers \Healthengine\Prometheus\PrometheusServiceProvider
 * @uses \Healthengine\Prometheus\Collector\QueueCollector
 */
class PrometheusServiceProviderTest extends TestCase
{
    public function testItRegisters(): void
    {
        /** @var PrometheusExporter $prometheusExporter */
        $prometheusExporter = resolve(PrometheusExporter::class);

        $this->assertInstanceOf(QueueCollector::class, $prometheusExporter->getCollector('queue'));

        $expectedConfig = require __DIR__ . '/../config/prometheus-collectors.php';

        $this->assertEquals($expectedConfig, config('prometheus-collectors'));
    }

    protected function getPackageProviders($app): array
    {
        return [
            PrometheusExporterServiceProvider::class,
            PrometheusServiceProvider::class,
        ];
    }
}
