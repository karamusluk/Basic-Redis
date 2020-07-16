<?php
include_once __DIR__.'/../vendor/autoload.php';

class UserRateCheck {

    /**
     * @var BasicRedis
     */
    public $DB;
    function __construct(){
        $this->DB = new BasicRedis();
        $this->DB->addConnection($_ENV["REDIS_NAME"], $_ENV["REDIS_HOST"], $_ENV["REDIS_PORT"]);
    }
    function checkUserLoginRate($username, $limit = null){
        $retryLimit = $limit ?? $_ENV["USER_RETRY_LIMIT"];
        $rate = $this->DB->getKey($username);
        if(empty($rate)){
            $this->DB->setKey($username, 1, $_ENV["USER_RETRY_TIMEOUT"]);
        } else {
            if ($rate >= $retryLimit) {
                echo "Too much Request!";
                exit;
            } else {
                $this->DB->incrementValue($username);
            }
        }
        $rate = $this->DB->getKey($username);
        echo "Retry Count: ". $rate;
    }
}

$rateCheck = new UserRateCheck();
$rateCheck->checkUserLoginRate("username");