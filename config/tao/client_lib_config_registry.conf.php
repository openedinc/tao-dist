<?php
/**
 * Default config header
 *
 * To replace this add a file tao/config/header/client_lib_config_registry.conf.php
 */

return array(
    'util/locale' => array(
        'decimalSeparator' => '.',
        'thousandsSeparator' => ''
    ),
    'taoQtiItem/qtiRunner/core/QtiRunner' => array(
        'inlineModalFeedback' => false
    ),
    'taoQtiTest/controller/runtime/testRunner' => array(
        'qtiTools' => array(
            'markForReview' => array(
                'hook' => 'taoQtiTest/testRunner/actionBar/markForReview',
                'order' => 'last'
            ),
            'collapseReview' => array(
                'hook' => 'taoQtiTest/testRunner/actionBar/collapseReview',
                'order' => 'first'
            ),
            'comment' => array(
                'hook' => 'taoQtiTest/testRunner/actionBar/comment'
            )
        )
    )
);
