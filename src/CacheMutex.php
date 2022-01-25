<?php

namespace fortrabbit\MemcachedEnabler;

use yii\caching\CacheInterface;

class CacheMutex extends \yii\mutex\Mutex
{
    const CACHE_VALUE = 1;

    /**
     * @var int Number of milliseconds between each try in [[acquire()]] until specified timeout times out.
     * By default it is 200 milliseconds - it means that [[acquire()]] may try acquiring up to 5 times per second.
     */
    public $retryDelay = 200;

    /**
     * @var int the number of seconds in which the lock will be auto released.
     */
    public $expire = 30;

    /**
     * @var \yii\caching\CacheInterface
     */
    public $cache;


    public function __construct(CacheInterface $cache, array $config = [])
    {
        $this->cache = $cache;
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function acquireLock($name, $timeout = 0): bool
    {
        $remainingTimeInMilliseconds = $timeout * 1000;

        // Retry until no time left
        while ($this->isLocked($name) && $remainingTimeInMilliseconds > 0) {
            $remainingTimeInMilliseconds = $remainingTimeInMilliseconds - $this->retryDelay;
        }

        // Still acquired?
        if ($this->isLocked($name)) {
            return false;
        }

        return $this->cache->set($name, self::CACHE_VALUE, $this->expire);
    }

    /**
     * @inheritdoc
     */
    public function releaseLock($name): bool
    {
        return $this->cache->delete($name);
    }


    public function isLocked(string $name): bool
    {
        return (bool) $this->cache->get($name);
    }
}
