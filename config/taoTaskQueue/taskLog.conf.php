<?php
/**
 * Default config header created during install
 */

return new oat\taoTaskQueue\model\TaskLog(array(
    'task_log_broker' => new oat\taoTaskQueue\model\TaskLogBroker\RdsTaskLogBroker('default', 'task_log')
));
