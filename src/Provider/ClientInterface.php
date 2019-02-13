<?php

namespace Kibernika\SMS\Provider;


interface ClientInterface
{
    /**
     * @param $method
     * @param $uri
     * @param $attributes
     *
     * @return Psr\Http\Message\ResponseInterface
     */
  public function request($method, $uri, $attributes);
}
