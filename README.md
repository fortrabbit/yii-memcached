# Craft CMS memcached enabler

This yii-extension is a memcached drop in replacement for sessions, cache and mutex. The file `Session` handler and the file `Cache` driver are getting replaced to work with Memcache without the need for further configuration for Pro Apps hosted on fortrabbit.

## Requirements

* Craft CMS (Version 3, 4, 5)
* A Professional App on fortrabbit (see below for other hosting providers)

## Install

1. Install the extension with Composer `composer require fortrabbit/yii-memcached`
2. Deploy the `composer.json` and `composer.lock` file with Git
3. **That's it**

## Non-fortrabbit environments

Provide the following ENV vars, if your application is not running on fortrabbit:

* `MEMCACHE_COUNT` (int, number of Memcached servers)
* `MEMCACHE_HOST1` (host name of first Memcached server)
* `MEMCACHE_PORT1` (port of first Memcached server)
* `MEMCACHE_HOST(n)` (host name of nth Memcached server)
* `MEMCACHE_PORT(n)` (port of nth Memcached server)

## Good to know

* Read the fortrabbit [Memcache help](https://help.fortrabbit.com/memcache-pro) why this is mandatory in multi node environments
* This is not a Craft CMS plugin but an extension for the underlying Yii framework
* This is not required for Universal Apps hosted on fortrabbit, since there is no Memcache and the file system is persistent
