<?php
/**
 * Default config header
 *
 * To replace this add a file /Users/lars/code/opened/tao/generis/config/header/passwords.conf.php
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
