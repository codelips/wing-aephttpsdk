<?php

namespace WingAepSDK;

use WingAepSDK\Api\AepBaseApi;
use WingAepSDK\Core\AepSDKRequest;

/**
 * Class AepSDKProxy
 * @package WingAepSDK
 */
class AepSDKProxy
{
    /**
     * @var AepSDKRequest|null
     */
    private static $request = null;
    /**
     * @var AepSDKProxy|null
     */
    private static $instance = null;
    private        $proxy    = null;

    public function __construct($appKey, $appSecret, $masterKey = null)
    {
        self::$request = new AepSDKRequest($appKey, $appSecret, $masterKey);
    }

    public static function s($appKey = '', $appSecret = '', $masterKey = null)
    {
        return self::$instance = new static($appKey, $appSecret, $masterKey);
    }

    public function for(AepBaseApi $class)
    {
        $this->proxy = $class;
        $this->proxy->setRequest(self::$request);
        return $this->proxy;
    }

    public function __call($name, $arguments)
    {
        if ($this->proxy === null) {
            throw  new \Exception("Proxy is not Instance");
        }
        return $this->proxy->$name(...$arguments);
    }

}