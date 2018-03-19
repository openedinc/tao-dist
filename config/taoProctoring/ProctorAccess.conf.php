<?php
/**
 * Default config header created during install
 */

return new oat\taoProctoring\model\ProctorServiceDelegator(array(
    'handlers' => array(
        new oat\taoProctoring\model\ProctorService()
    )
));
