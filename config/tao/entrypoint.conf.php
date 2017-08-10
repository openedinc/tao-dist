<?php
/**
 * Default config header
 *
 * To replace this add a file tao/config/header/entrypoint.conf.php
 */

return new oat\tao\model\entryPoint\EntryPointService(array(
    'existing' => array(
        'passwordreset' => new oat\tao\model\entryPoint\PasswordReset(),
        'deliveryServer' => new taoDelivery_models_classes_entrypoint_FrontOfficeEntryPoint(),
        'backoffice' => new oat\taoCe\model\entryPoint\TaoCeEntrypoint(),
        'guestaccess' => new oat\taoDeliveryRdf\model\guest\GuestAccess()
    ),
    'postlogin' => array(
        'deliveryServer',
        'backoffice'
    ),
    'prelogin' => array(
        'guestaccess'
    )
));
