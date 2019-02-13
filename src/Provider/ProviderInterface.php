<?php

namespace Kibernika\SMS\Provider;

use Kibernika\SMS\Response;
use Kibernika\SMS\Message;

interface ProviderInterface
{
    /**
     * Sends a message through the gateway.
     *
     * @param Message $message Message
     * @param bool    $debug   If debug mode should be enabled
     *
     * @return Response
     */
    public function send(Message $message, $debug = false);

    /**
     * Fetches all queued messages from gateway.
     *
     * @param string $number The number to fetch messages from
     *
     * @return Message[]
     */
    public function fetch($number);
}
