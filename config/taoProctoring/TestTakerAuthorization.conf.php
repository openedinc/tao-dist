<?php
/**
 * Manages the test-taker authorization to the deliveries
 */
return new oat\taoProctoring\model\authorization\TestTakerAuthorizationDelegator(array(
    'handlers' => array(
        new oat\taoProctoring\model\authorization\TestTakerAuthorizationService()
    )
));
