<?php
/**
 * Default config header created during install
 */

return new oat\tao\model\entryPoint\EntryPointService(array(
    'existing' => array(
        'passwordreset' => new oat\tao\model\entryPoint\PasswordReset(),
        'deliveryServer' => new oat\taoProctoring\model\entrypoint\ProctoringDeliveryServer(),
        'backoffice' => new oat\taoCe\model\entryPoint\TaoCeEntrypoint(),
        'guestaccess' => new oat\taoDeliveryRdf\model\guest\GuestAccess(),
        'proctoring' => new oat\taoProctoring\model\entrypoint\ProctoringEntryPoint()
    ),
    'postlogin' => array(
        'deliveryServer',
        'backoffice',
        'proctoring'
    ),
    'prelogin' => array(
        'guestaccess'
    )
));
