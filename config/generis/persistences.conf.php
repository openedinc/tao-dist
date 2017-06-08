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
            'host' => 'ec2-23-21-220-48.compute-1.amazonaws.com',
            'dbname' => 'denf7cjo8to9or',
            'user' => 'xzhbkwcodgdmti',
            'password' => '06b8936eb6ef74b4d1817d7e023879028ac3f480044892245d7c74b5c409a950'
        ),
        'serviceState' => array(
            'driver' => 'phpfile'
        )
    )
));
