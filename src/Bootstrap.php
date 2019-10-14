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

    const TIMEOUT_IN_MILLISECONDS = 50;

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
                    'options'      => $this->getOptions(),
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
                'weight'        => 1,
            ];
        }

        return $servers;
    }

    /**
     * @return array
     */
    protected function getOptions(): array
    {
        if (!extension_loaded('memcached')) {
            return [];
        }

        return [

            // Assure that dead servers are properly removed and ...
            \Memcached::OPT_REMOVE_FAILED_SERVERS => true,

            // ... retried after a short while (here: 2 seconds)
            \Memcached::OPT_RETRY_TIMEOUT         => 2,

            // KETAMA must be enabled so that replication can be used
            \Memcached::OPT_LIBKETAMA_COMPATIBLE  => true,

            // Replicate the data, i.e. write it to both memcached servers
            \Memcached::OPT_NUMBER_OF_REPLICAS    => 1,

            // Those values assure that a dead (due to increased latency or
            // really unresponsive) memcached server increased dropped fast
            // and the other is used.
            \Memcached::OPT_POLL_TIMEOUT          => self::TIMEOUT_IN_MILLISECONDS,           // milliseconds
            \Memcached::OPT_SEND_TIMEOUT          => self::TIMEOUT_IN_MILLISECONDS * 1000,    // microseconds
            \Memcached::OPT_RECV_TIMEOUT          => self::TIMEOUT_IN_MILLISECONDS * 1000,    // microseconds
            \Memcached::OPT_CONNECT_TIMEOUT       => self::TIMEOUT_IN_MILLISECONDS,           // milliseconds

            // Further performance tuning
            \Memcached::OPT_NO_BLOCK              => true,
        ];
    }
}
