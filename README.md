# Yii2/Craft3 memcached enabler

This yii-extension is a memcached drop in replacement for sessions and cache. 

The file `Session` handler and the file `Cache` driver gets replaced in [fortrabbit](https://help.fortrabbit.com/stacks) environments - it requires the Memcache component on the Professional Stack.
[Read on why Memcache](https://help.fortrabbit.com/memcache-pro) is mandatory in multi node environments 

## Install

Require the package:
```
composer require fortrabbit/yii-memcached
```

Deploy the `composer.json` and `composer.lock` file.

**That's it.**

## Non-fortrabbit environments

If your application does not run on fortrabbit, you need to provide the following ENV vars to make it work:

* `MEMCACHE_COUNT` (int, number of Memcached servers)
* `MEMCACHE_HOST1` (host name of first Memcached server)
* `MEMCACHE_PORT1` (port of first Memcached server)
* `MEMCACHE_HOST(n)` (host name of nth Memcached server)
* `MEMCACHE_PORT(n)` (port of nth Memcached server)

