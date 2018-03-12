<?php
/**
 * Default config header created during install
 */

return new oat\taoEventLog\model\LoggerService(array(
    'storage' => 'taoEventLog/storage',
    'rotation_period' => 'P90D',
    'exportable_quantity' => 10000,
    'exportable_period' => 'PT24H'
));
