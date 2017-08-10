<?php
/**
 * Default config header
 *
 * To replace this add a file tao/config/header/SimpleAclWhitelist.conf.php
 */

return array(
    'tao_actions_Main' => array(
        'entry' => '*',
        'login' => '*',
        'logout' => '*'
    ),
    'tao_actions_PasswordRecovery' => array(
        'index' => '*',
        'resetPassword' => '*'
    ),
    'tao_actions_ClientConfig' => '*',
    'taoResultServer_actions_RestResultServer' => '*',
    'oat\\taoTestTaker\\actions\\Api' => '*',
    'oat\\taoGroups\\controller\\Api' => '*',
    'taoTests_actions_RestTests' => '*',
    'oat\\taoDeliveryRdf\\controller\\Guest' => array(
        'guest' => '*'
    )
);
