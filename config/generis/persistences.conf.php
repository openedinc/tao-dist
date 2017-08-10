<?php
/**
 * The persistence configuration contains a list of persistences
 * identified by name.
 * 
 * See common_persistence_Manager for a list of drivers
 * provided by  generis. Aditional drivers can be used by setting
 * the drivers full class name
 *
 * @author Open Assessment Technologies SA
 * @package generis
 * @license GPLv2  http://www.opensource.org/licenses/gpl-2.0.php
 * @see common_persistence_Manager
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
        )
    )
));
