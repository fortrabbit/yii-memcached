# Changelog

All notable changes to this project will be documented in this file.

## [1.4.0] - 2022-05-05
Support for Craft 4 added. 

## [1.3.1] - 2022-05-01
Previous release wasn't tagged correctly. 


## [1.3.0] - 2022-01-25
- depends on Craft 3.7.30
- uses Cache mutex (Memcached driver) 

## [1.2.0] - 2021-02-08
- added `fortrabbit\MemcachedEnabler\MemCache` class 
- wrapped `setValues()` and `setValue()` in a try / catch 

## [1.1.1] - 2021-01-27
Prevent warning `Memcached::addServer()` expects parameter 2 to be int, string given, thanks @joshuabaker

## [1.1.0] - 2019-10-18
Added fault-tolerant multi-server support 🎉
by applying the following options:

Redundancy

```
Memcached::OPT_REMOVE_FAILED_SERVERS: true
Memcached::OPT_RETRY_TIMEOUT: 2
Memcached::OPT_LIBKETAMA_COMPATIBLE: true
Memcached::OPT_NUMBER_OF_REPLICAS: 1
```

Timeouts

```
Memcached::OPT_POLL_TIMEOUT: 50 ms
Memcached::OPT_SEND_TIMEOUT: 50 ms
Memcached::OPT_RECV_TIMEOUT: 50 ms
Memcached::OPT_CONNECT_TIMEOUT: 50 ms
```
 
## [1.0.0]

Initial release
