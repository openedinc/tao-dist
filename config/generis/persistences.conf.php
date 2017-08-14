<?php
/**
 * Default config header created during install
 */

return new common_persistence_Manager(array(
    'persistences' => array(
        'cache' => array(
            'driver' => 'phpfile'
        ),
        'default' => array(
            'driver' => 'pdo_pgsql',
            'host' => getenv('DB_HOST'),
            'dbname' => getenv('DB_NAME'),
            'user' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD'),
            'port' => getenv('DB_PORT')
        ),
        'serviceState' => array(
            'driver' => 'phpfile'
        ),
        'maintenance' => array(
            'driver' => 'phpfile'
        )
    )
));
