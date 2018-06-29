<?php
/**
 * Default config header created during install
 */

return new tao_models_classes_service_FileStorage(array(
    'public' => 'public',
    'private' => 'private',
    'provider' => getenv('PUBLIC_WEBSOURCE_ID')
));
