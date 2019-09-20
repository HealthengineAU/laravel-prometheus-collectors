<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Queues
    |--------------------------------------------------------------------------
    |
    | The queue names to export metrics for.
    |
    */

    /* Associative array describes the queues in the following way
     * queue label => queue name
     * The label will be used to describe the queue in prometheus
     * and the name will be passed to the QueueManager to determine the sizes
    */
    'queues' => [
        'default' => 'default',
    ],

    'include_failed_queue' => true,

];
