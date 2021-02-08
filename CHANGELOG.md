
## v1.2.0


## v1.1.1

Prevent warning Memcached::addServer() expects parameter 2 to be int, string given, thanks @joshuabaker

## v1.1.0
@ostark ostark released this on 18 Oct 2019

Added fault-tolerant multi-server support 🎉
by applying the following options:

Redundancy

Memcached::OPT_REMOVE_FAILED_SERVERS: true
Memcached::OPT_RETRY_TIMEOUT: 2
Memcached::OPT_LIBKETAMA_COMPATIBLE: true
Memcached::OPT_NUMBER_OF_REPLICAS: 1
Timeouts

Memcached::OPT_POLL_TIMEOUT: 50 ms
Memcached::OPT_SEND_TIMEOUT: 50 ms
Memcached::OPT_RECV_TIMEOUT: 50 ms
Memcached::OPT_CONNECT_TIMEOUT: 50 ms

 
## v1.0.0

Initial release
