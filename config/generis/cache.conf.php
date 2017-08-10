<?php
/**
 * Default config header
 *
 * To replace this add a file generis/config/header/cache.conf.php
 */

return new common_cache_KeyValueCache(array(
    'persistence' => 'cache'
));
