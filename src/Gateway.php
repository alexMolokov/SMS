<?php

namespace Kibernika\SMS;
use Kibernika\SMS\Provider\ProviderInterface;
use Assert\Assert;


class Gateway
{
    /**
     * @var ProviderInterface Provider
     */
    private $provider;

    /**
     * @var bool Debug mode
     */
    private $debugMode;

    /**
     * __construct()
     *
     * @param ProviderInterface $provider
     * @param bool $debugMode Enables or disables debug mode
     */
    public function __construct(ProviderInterface $provider, $debugMode = false)
    {
        $this->provider = $provider;
        $this->setDebugMode($debugMode);
    }

    /**
     * Enables or disables debug mode.
     *
     * @param bool $state
     *
     * @return $this
     */
    public function setDebugMode($state)
    {
        Assert::that($state)->notEmpty()->boolean();
        $this->debugMode = $state;
        return $this;
    }

    /**
     * Sends a message through the gateway.
     *
     * @param Message $message
     *
     * @return \Kibernika\SMS\Response
     */
    public function send(Message $message)
    {
        return $this->provider->send($message, $this->debugMode);
    }

    /**
     * Fetches all queued messages from gateway.
     *
     * @param string $number The number to fetch messages from
     *
     * @return Message[]
     */
    public function fetch($number)
    {
        Assert::that($number)->notEmpty()->integer()->min(1);
        return $this->provider->fetch($number);
    }
}
