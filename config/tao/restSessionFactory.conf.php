<?php
/**
 * Default config header created during install
 */

return new oat\tao\model\session\restSessionFactory\RestSessionFactory(array(
    'builders' => array(
        'oat\\tao\\model\\session\\restSessionFactory\\builder\\HttpBasicAuthBuilder'
    )
));
