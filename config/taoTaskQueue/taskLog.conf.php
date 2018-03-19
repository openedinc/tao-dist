<?php
/**
 * Default config header created during install
 */

return new oat\taoTaskQueue\model\TaskLog(array(
    'task_log_broker' => new oat\taoTaskQueue\model\TaskLogBroker\RdsTaskLogBroker('default', 'task_log'),
    'task_to_category_associations' => array(
        'oat\\taoQtiItem\\model\\tasks\\ImportQtiItem' => 'import',
        'oat\\taoQtiTest\\models\\tasks\\ImportQtiTest' => 'import',
        'oat\\taoDeliveryRdf\\model\\tasks\\CompileDelivery' => 'delivery_comp',
        'oat\\taoOutcomeUi\\scripts\\task\\ExportDeliveryResults' => 'export'
    )
));
