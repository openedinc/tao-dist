<?php
/**
 * Default config header created during install
 */

return new oat\taoProctoring\model\monitorCache\implementation\MonitorCacheService(array(
    'persistence' => 'default',
    'use_update_multiple' => false,
    'primary_columns' => array(
        'delivery_execution_id',
        'status',
        'current_assessment_item',
        'test_taker',
        'authorized_by',
        'start_time',
        'end_time',
        'delivery_id',
        'delivery_name'
    )
));
