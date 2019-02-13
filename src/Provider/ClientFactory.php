<?php
/**
 * Created by PhpStorm.
 * User: Анастасия
 * Date: 11.02.2019
 * Time: 16:21
 */

namespace Kibernika\SMS\Provider;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

class ClientFactory
{
    private static $client;

    public static function create($config = []) {
        if(self::$client === null)  self::setClient(new Client($config));

        return self::$client;
    }

    public static function setClient(ClientInterface $client)
    {
        self::$client = $client;
    }

    public static function reset() {
        self::$client = null;
    }
}