<?php
/**
 * Default config header created during install
 */

return new oat\taoEventLog\model\eventLog\LoggerService(array(
    'storage' => 'taoEventLog/eventLogStorage',
    'rotation_period' => 'P90D',
    'exportable_quantity' => 10000,
    'exportable_period' => 'PT24H'
));
