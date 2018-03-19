<?php
/**
 * Default config header created during install
 */

return new oat\tao\model\actionQueue\implementation\InstantActionQueue(array(
    'persistence' => 'cache',
    'actions' => array(
        'oat\\ltiDeliveryProvider\\model\\actions\\GetActiveDeliveryExecution' => array(
            'limit' => 0,
            'ttl' => 3600
        )
    )
));
