<?php

namespace fortrabbit\MemcachedEnabler;


class MemCache extends \yii\caching\MemCache
{
    /**
     * @inheritDoc
     */
    protected function setValues($data, $duration)
    {
       try {
           return parent::setValues($data, $duration);
       } catch (\ErrorException $exception) {
           error_log('MemcachedEnabler: ' . $exception->getMessage());
           return array_keys($data);
       }
    }

    /**
     * @inheritDoc
     */
    protected function setValue($key, $value, $duration)
    {
        try {
            return parent::setValue($key, $value, $duration);
        } catch (\ErrorException $exception) {
            error_log('MemcachedEnabler: ' . $exception->getMessage());
            return false;
        }
    }
}
