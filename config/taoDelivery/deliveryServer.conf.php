<?php
/**
 * Default config header
 *
 * To replace this add a file taoDelivery/config/header/deliveryServer.conf.php
 */

return new taoDelivery_models_classes_DeliveryServerService(array(
    'requireFullScreen' => false,
    'deliveryContainer' => 'oat\\taoDelivery\\helper\\container\\DeliveryServiceContainer'
));
