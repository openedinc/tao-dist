<?php
/**
 * Tao Authorization service ensures a test-taker is authorized
 * to start and/or resume a test
 * 
 * By default implemented by AuthorizationAggregator
 * allowing multiple AuthorizationProviders to be verified
 */

return new oat\taoDelivery\model\authorization\strategy\AuthorizationAggregator(array(
    'providers' => array(
        1 => new oat\taoProctoring\model\authorization\ProctorAuthorizationProvider()
    )
));
