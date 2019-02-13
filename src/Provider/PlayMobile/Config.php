<?php
/**
 * Created by PhpStorm.
 * User: Анастасия
 * Date: 11.02.2019
 * Time: 15:01
 */

namespace Kibernika\SMS\Provider\PlayMobile;


class Config
{

        private $login;
        private $password;
        private $url;

        private $timeout = 10;

     public function __construct(array $data)
     {
         foreach($data as $key => $value)
         {
             if(property_exists($this,$key)) $this->{$key} = $value;
         }
     }

    /**
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return int
     */
    public function getTimeout()
    {
        return $this->timeout;
    }






}