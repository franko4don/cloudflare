<?php
namespace Frank\Cloudflare\Helpers;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;
use Exception;

/**
 * @method mixed post($url, $_ = null)
 * @method mixed get($url, $_ = null)
 * @method mixed patch($url, $_ = null)
 * @method mixed post($url, $_ = null)
 * @method mixed put($url, $_ = null)
 */
class Http
{

    private static $client;
    private static $response;

    public static function client()
    {
        if (!self::$client) self::$client = new Client;
        return self::$client;
    }

    public static function processJsonResponse(ResponseInterface $response, $toArray = true)
    {
        return json_decode(strval($response->getBody()), $toArray);
    }

    private static function req($method, array $args)
    {
        array_unshift($args, $method);
        return call_user_func_array([get_called_class(), 'request'], $args);
    }

    public static function request($method, $url, $_ = null)
    {
        $args = func_get_args();
        array_shift($args);
        $args[1]['http_errors'] = false;

        self::$response = call_user_func_array([static::client(), $method], $args);

        return static::processJsonResponse(self::$response);
    }
    
    public static function requestAsync($method, $url, $_ = null) {
        $args = func_get_args();
        array_shift($args);
        $args[1]['http_errors'] = false;
        return call_user_func_array([static::client(), $method . 'Async'], $args);
    }

    public static function hasErrors() {
        return static::getStatusCode() >= 400;
    }

    public static function getStatusCode() {
        return self::$response ? self::$response->getStatusCode() : 0;
    }

    public static function rawResponse() {
        return self::$response;
    }

    public static function response() {
        return static::processJsonResponse(self::$response);
    }

    public static function respond()
    {
        return response()->json(static::response(), static::getStatusCode());
    }

    public static function __callStatic($method, $args)
    {
        return static::req($method, $args);
    }

}
