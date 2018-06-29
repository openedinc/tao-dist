<?php
/**
 * Default config header created during install
 */

return new oat\taoQtiItem\model\portableElement\storage\PortableElementFileStorage(array(
    'filesystem' => 'portableElementStorage',
    'websource' => getenv('PORTABLE_WEBSOURCE_ID')
));
