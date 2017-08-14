<?php
/**
 * Default config header created during install
 */

return new oat\oatbox\config\ConfigurationService(array(
    'config' => array(
        'className' => 'oat\\tao\\model\\websource\\TokenWebSource',
        'options' => array(
            'secret' => '9e9633cf8bf0cef32ced6fdd80f2ab1c',
            'path' => ROOT_PATH.'data/tao/public/',
            'ttl' => 1440,
            'fsUri' => 'public',
            'id' => '5991bf717a9e6'
        )
    )
));
