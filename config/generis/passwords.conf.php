<?php
/**
 * Default config header
 *
 * To replace this add a file generis/config/header/passwords.conf.php
 */

return array(
    'constrains' => array(
        'length' => 4,
        'upper' => false,
        'lower' => true,
        'number' => false,
        'spec' => false
    ),
    'generator' => array(
        'chars' => 'abcdefghijklmnopqrstuvwxyz',
        'nums' => '0123456789',
        'syms' => '!@#$%^&*()-+?',
        'similar' => 'iIl1Oo0',
        'dictionary' => '/usr/share/dict/words'
    )
);