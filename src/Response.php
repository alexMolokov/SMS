<?php

namespace Kibernika\SMS;

class Response
{
    /**
     * @var bool Sending successful
     */
    private $successful;

    /**
     * @var int Timestamp message was sent
     */
    private $timestamp;

    /**
     * @var mixed Gateway provider response code
     */
    private $responseCode;

    /**
     * @var mixed Gateway provider response message
     */
    private $message;

    /**
     * __construct()
     *
     * @param int  $tstamp     Timestamp
     * @param bool $successful Was successful
     * @param null $code       Response code
     * @param string $message    Message
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($tstamp, $successful, $code = null, $message = null)
    {
        if (!is_int($tstamp) || $tstamp < 0 || !is_bool($successful)) {
            throw new \InvalidArgumentException();
        }

        $this->timestamp = $tstamp;
        $this->successful = $successful;
        $this->responseCode = $code;
        $this->message = $message;
    }

    /**
     * Returns the sending tstamp.
     *
     * @return int
     */
    public function getTstamp()
    {
        return $this->timestamp;
    }

    /**
     * Returns the gateway response code.
     *
     * @return mixed
     */
    public function getResponseCode()
    {
        return $this->responseCode;
    }

    /**
     * Returns the gateway response message.
     *
     * @return mixed
     */
    public function getResponseMessage()
    {
        return $this->message;
    }

    /**
     * Returns if the sending was successful.
     *
     * @return bool
     */
    public function wasSuccessful()
    {
        return $this->successful;
    }
}
