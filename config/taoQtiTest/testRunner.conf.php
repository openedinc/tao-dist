<?php
/**
 * Default config header
 *
 * To replace this add a file /Users/lars/code/opened/tao/taoQtiTest/config/header/testRunner.conf.php
 */

return array(
    'timerWarning' => array(
        'assessmentItemRef' => null,
        'assessmentSection' => null,
        'testPart' => null
    ),
    'progress-indicator' => 'percentage',
    'progress-indicator-scope' => 'testSection',
    'progress-indicator-forced' => false,
    'test-taker-review' => false,
    'test-taker-review-region' => 'left',
    'test-taker-review-force-title' => false,
    'test-taker-review-item-title' => 'Item %d',
    'test-taker-review-scope' => 'test',
    'test-taker-review-prevents-unseen' => true,
    'test-taker-review-can-collapse' => false,
    'exitButton' => false,
    'next-section' => false,
    'reset-timer-after-resume' => false,
    'extraContextBuilder' => null,
    'plugins' => null,
    'csrf-token' => true,
    'timer' => array(
        'target' => 'server'
    )
);
