<?php

namespace fortrabbit\MemcachedEnabler;

use yii\base\BootstrapInterface;
use yii\base\InvalidConfigException;
use yii\caching\MemCache;

/**
 * Class Bootstrap
 *
 * @author Oliver Stark <os@fortrabbit.com>
 * @since  1.0.0
 */
class Bootstrap implements BootstrapInterface
{

    /**
     * Bootstrapper
     *
     * @param \yii\base\Application $app
     */
    public function bootstrap($app)
    {

        if (getenv('MEMCACHE_COUNT')) {

            // Set cache component
            try {
                $app->set('cache', [
                    'class'        => MemCache::class,
                    'persistentId' => getenv('MEMCACHE_PERSISTENT') ? 'cache' : null,
                    'servers'      => $this->getMemcachedServers(),
                    'useMemcached' => true
                ]);
            } catch (InvalidConfigException $e) {
                error_log('MemcachedEnabler: ' . $e->getMessage());
            }
        }
    }


    /**
     * @return array
     */
    protected function getMemcachedServers(): array
    {
        $servers = [];

        foreach (range(1, getenv('MEMCACHE_COUNT')) as $num) {
            $servers[] = [
                'host'          => getenv('MEMCACHE_HOST' . $num),
                'port'          => getenv('MEMCACHE_PORT' . $num),
                'retryInterval' => 2,
                'status'        => true,
                'timeout'       => 2,
                'weight'        => 1,
            ];
        }

        return $servers;
    }
}
