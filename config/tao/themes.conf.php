<?php
/**
 * Default config header
 *
 * To replace this add a file tao/config/header/themes.conf.php
 */

return array(
    'items' => array(
        'base' => 'taoQtiItem/views/css/qti-runner.css',
        'available' => array(
            array(
                'id' => 'tao',
                'name' => 'TAO',
                'path' => 'taoQtiItem/views/css/themes/default.css'
            )
        ),
        'default' => 'tao'
    )
);
