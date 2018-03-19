<?php
/**
 * Default config header created during install
 */

return new oat\tao\model\oauth\OauthService(array(
    'store' => new oat\tao\model\oauth\DataStore(array(
        'nonce' => new oat\tao\model\oauth\nonce\NoNonce()
    ))
));
