<?php

declare(strict_types=1);

namespace Tests\Collector;

use Healthengine\LaravelPrometheusExporter\PrometheusExporter;
use Healthengine\LaravelPrometheusExporter\PrometheusServiceProvider as PrometheusExporterServiceProvider;
use Healthengine\Prometheus\Collector\QueueCollector;
use Healthengine\Prometheus\PrometheusServiceProvider;
use Orchestra\Testbench\TestCase;
use PHPUnit\Framework\MockObject\Exception;
use Prometheus\CollectorRegistry;
use Prometheus\Sample;
use Prometheus\Storage\InMemory;

/**
 * @covers \Healthengine\Prometheus\Collector\QueueCollector
 */
class QueueCollectorTest extends TestCase
{
    public function testItsNameIsQueue(): void
    {
        /** @var QueueCollector $queueCollector */
        $queueCollector = resolve(QueueCollector::class);

        $this->assertEquals('queue', $queueCollector->getName());
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testItRegistersMetrics(): void
    {
        $prometheusExporter = $this->createMock(PrometheusExporter::class);
        $prometheusExporter
            ->expects($this->once())
            ->method('registerGauge')
            ->with('queue_lengths', 'Pending jobs in the queue', ['queue_name']);

        /** @var QueueCollector $queueCollector */
        $queueCollector = resolve(QueueCollector::class);
        $queueCollector->registerMetrics($prometheusExporter);
    }

    public function testItCollects(): void
    {
        $inMemoryAdapter = new InMemory();

        $prometheusExporter = new PrometheusExporter(
            '',
            new CollectorRegistry($inMemoryAdapter, false),
            [
                resolve(QueueCollector::class),
            ]
        );
        $prometheusExporter->export();

        $results = $inMemoryAdapter->collect();

        $this->assertEquals([
            new Sample([
                'name' => 'queue_lengths',
                'labelNames' => [],
                'labelValues' => [
                    'default',
                ],
                'value' => 0.0,
            ]),
            new Sample([
                'name' => 'queue_lengths',
                'labelNames' => [],
                'labelValues' => [
                    'failed',
                ],
                'value' => 0.0,
            ]),
        ], $results[0]->getSamples());
    }

    protected function defineDatabaseMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../workbench/database/migrations');
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('queue.default', 'database');
    }

    protected function getPackageProviders($app): array
    {
        return [
            PrometheusExporterServiceProvider::class,
            PrometheusServiceProvider::class,
        ];
    }
}
