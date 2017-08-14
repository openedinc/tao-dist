<?php
/**
 * Default config header created during install
 */

return new oat\taoQtiTest\models\cat\CatService(array(
    'endpoints' => array(
        'http://URL_SERVER/cat/api/' => array(
            'class' => 'oat\\libCat\\custom\\EchoAdaptEngine',
            'args' => array(
            )
        )
    )
));
