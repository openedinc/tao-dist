<?php
/**
 * Default config header
 *
 * To replace this add a file generis/config/header/event.conf.php
 */

return new oat\oatbox\event\EventManager(array(
    'listeners' => array(
        'oat\\generis\\model\\data\\event\\ResourceCreated' => array(
            array(
                'oat\\generis\\model\\data\\permission\\PermissionManager',
                'catchEvent'
            )
        )
    )
));
