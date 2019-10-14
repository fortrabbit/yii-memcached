<?php
// Very early session handler init
// This file is loaded via composer autoload.files

if (getenv('MEMCACHE_COUNT')) {

    $handlers = [];
    foreach (range(1, getenv('MEMCACHE_COUNT')) as $num) {
        $handlers[] = getenv('MEMCACHE_HOST' . $num) . ':' . getenv('MEMCACHE_PORT' . $num);
    }

    // session config
    ini_set('session.save_handler', 'memcached');
    ini_set('session.save_path', implode(',', $handlers));
    ini_set('memcached.sess_locking', 0);

    if (getenv('MEMCACHE_COUNT') == 2) {
        ini_set('memcached.sess_number_of_replicas', 1);
        ini_set('memcached.sess_consistent_hash', 1);
        ini_set('memcached.sess_binary', 1);
        ini_set('memcached.sess_remove_failed_servers', 1);
    }
}

