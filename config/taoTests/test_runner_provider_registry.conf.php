<?php
/**
 * Default config header created during install
 */

return new oat\oatbox\config\ConfigurationService(array(
    'config' => array(
        'taoQtiTest/runner/provider/qti' => array(
            'id' => 'qti',
            'module' => 'taoQtiTest/runner/provider/qti',
            'bundle' => 'taoQtiTest/loader/qtiTestRunner.min',
            'position' => null,
            'name' => 'QTI runner',
            'description' => 'QTI implementation of the test runner',
            'category' => 'runner',
            'active' => true,
            'tags' => array(
                'core',
                'qti',
                'runner'
            )
        )
    )
));
