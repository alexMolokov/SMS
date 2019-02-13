<?php
use PHPUnit\Framework\TestCase;
use Kibernika\SMS\Provider\PlayMobile\Config;

class ConfigTest extends TestCase
{

    private $login = "";
    private $password = "";
    private $url = "";
    private $timeout = 10;

    public function setUp() {
        $this->login = "aaa";
        $this->password = "aaaaa";
        $this->url = "http://yandex.ru";
        $this->timeout = 10;
     }
    
    public function testConstructConfig() {
        $config = new Config(["login" => $this->login, "password" => $this->password, "url" => $this->url, "timeout" => $this->timeout]);

        $this->assertEquals($this->login, $config->getLogin());
        $this->assertEquals($this->password, $config->getPassword());
        $this->assertEquals($this->timeout, $config->getTimeout());
        $this->assertEquals($this->url, $config->getUrl());
    }
}