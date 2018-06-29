<?php
/**
 * Default config header created during install
 */

return new oat\oatbox\config\ConfigurationService(array(
    'config' => array(
        'className' => 'oat\\tao\\model\\websource\\FlyTokenWebSource',
        'options' => array(
            'secret' => getenv('PUBLIC_WEBSOURCE_SECRET'),
            'path' => ROOT_PATH.'data/tao/public/',
            'ttl' => 1440,
            'fsUri' => 'public',
            'id' => getenv('PUBLIC_WEBSOURCE_ID')
        )
    )
));
