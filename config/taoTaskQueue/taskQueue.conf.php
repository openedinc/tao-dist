<?php
/**
 * Default config header created during install
 */

return new oat\taoTaskQueue\model\QueueDispatcher(array(
    'queues' => array(
        new oat\taoTaskQueue\model\Queue('queue', new oat\taoTaskQueue\model\QueueBroker\InMemoryQueueBroker(1), 1)
    ),
    'task_log' => 'taoTaskQueue/taskLog',
    'task_to_queue_associations' => array(
    ),
    'task_selector_strategy' => new oat\taoTaskQueue\model\TaskSelector\WeightStrategy()
));
