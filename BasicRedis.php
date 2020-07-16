<?php
use Predis\Client as RedisClient;
use Dotenv\Dotenv as Config;
Config::createMutable(__DIR__, '.env')->load();

class BasicRedis {

    /**
     * @var array
     */
    private $connections;
    /**
     * @var RedisClient
     */
    private $activeConnection;
    function __construct() {

    }

    public function addConnection($name, $host, $port = 6379, $setActive = true, $scheme = 'tcp'){
        $this->connections[$name] = new RedisClient([
            'scheme' => $scheme,
            'host'   => $host,
            'port'   => $port,
        ], ['parameters' => ['database' => 10]]);

        if($setActive){
            $this->setActiveConnection($this->connections[$name]);
        }
    }

    /**
     * @param $key
     * @return mixed
     */
    public function getKey($key){
        return  $this->getActiveConnection()->get($key);
    }

    public function incrementValue($key, $incrementBy = 1){
        return $this->getActiveConnection()->incrby($key, $incrementBy);
    }

    public function setKey($key, $value, $timeout){
        $this->getActiveConnection()->setex($key, $timeout, $value);
        $this->getActiveConnection()->expire($key, $timeout);
    }

    public function getActiveConnection(): RedisClient{
        return  $this->activeConnection;
    }

    public function getConnectionByName($name): ?RedisClient{
        return  $this->connections[$name] ?? null;
    }

    public function setActiveConnection($connection){
        $this->activeConnection = $connection;
    }
}