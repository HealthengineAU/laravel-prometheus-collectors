<?php

namespace HealthEngine\Prometheus\Collector;

use Illuminate\Database\Connection;
use Illuminate\Queue\QueueManager;
use Superbalist\LaravelPrometheusExporter\CollectorInterface;
use Superbalist\LaravelPrometheusExporter\PrometheusExporter;

class QueueCollector implements CollectorInterface
{
    /** @var QueueManager */
    protected $queueManager;

    /** @var Connection */
    protected $database;

    /** @var \Prometheus\Gauge */
    protected $lengthGauge;

    /** @var array The list of queues to monitor */
    protected $queues;

    public function __construct(QueueManager $queueManager, Connection $database, array $queues)
    {
        $this->queueManager = $queueManager;
        $this->database = $database;
        $this->queues = $queues;
    }

    /**
     * Return the name of the collector.
     *
     * @return string
     */
    public function getName()
    {
        'queue';
    }

    /**
     * Register all metrics associated with the collector.
     *
     * The metrics needs to be registered on the exporter object.
     * eg:
     * ```php
     * $exporter->registerCounter('search_requests_total', 'The total number of search requests.');
     * ```
     *
     * @param PrometheusExporter $exporter
     */
    public function registerMetrics(PrometheusExporter $exporter)
    {
        $this->lengthGauge = $exporter->registerGauge('queue_lengths', 'Pending jobs in the queue', ['queue_name']);
    }

    /**
     * Collect metrics data, if need be, before exporting.
     *
     * As an example, this may be used to perform time consuming database queries and set the value of a counter
     * or gauge.
     */
    public function collect()
    {
        // export the queue lengths
        foreach ($this->queues as $queue) {
            $this->lengthGauge->set($this->queueManager->size($queue), [$queue]);
        }
        // including the failed jobs if enabled
        if (config('prometheus-collectors.include_failed_queue')) {
            $count = $this->database->table('failed_jobs')->count();
            $this->lengthGauge->set($count, ['failed']);
        }
    }
}
