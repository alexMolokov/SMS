<?php

namespace Kibernika\SMS\Provider;

use Kibernika\SMS\Provider\PlayMobile\Config;
use Kibernika\SMS\Provider\PlayMobile\Priority;
use Kibernika\SMS\Exception\RequestException;
use Kibernika\SMS\Message;
use Kibernika\SMS\Response;

class PlayMobile implements ProviderInterface
{
    /**
     * @var Config
     */
    private $config;
    private $priority = Priority::NORMAL;
    private $client;
    private $provider = "PlayMobile";

  public function __construct(Config $config)
  {
      $this->config = $config;

      $this->client = ClientFactory::create([
          'base_uri' => $this->config->getUrl(),
          'timeout'  => $this->config->getTimeout()
      ]);
  }
    /**
     * @param mixed $priority
     */
  public function setPriority($priority)
  {
        if(!Priority::isPriority($priority))
            throw new \InvalidArgumentException("Not supported Priority");

        $this->priority = $priority;
  }

  public function getPriority()
  {
        return $this->priority;
  }


    /**
     * @param Message $message
     * @param bool $debug
     * @return Response
     * @throws RequestException
     */
  public function send(Message $message, $debug = false)
  {
      $sms = [
          "priority" => $this->priority,
          "sms" => [
              "originator" =>  $message->getFrom(),
              "content" =>  ["text" =>  $message->getMessageText()]
          ],
          "messages" => [
                "recipient" => $message->getTo()

          ]
      ];

      try
      {
          $response = $this->client->request("POST", "send", [
              "auth" =>  [
                  $this->config->getLogin(),
                  $this->config->getPassword()
              ],
              'json' => $sms
          ]);

          $code = null; $description = null;
          $successful = ($response->getStatusCode() == 200);

          if(!$successful)
          {
              if($response->getStatusCode() !== 400) throw new RequestException("Error response " . $this->provider . " service ", $response->getStatusCode());

              $body = (array) json_decode($response->getBody());
              $code = $body["error_code"];
              $description = $body["error_description"];
          }


          return new Response(time(),$successful, $code, $description);

      }
      catch (\Exception $e)
      {
          throw new RequestException($e->getMessage(), $e->getCode(),$e);
      }
  }

    /**
     * @param integer $number
     * @throws RequestException
     */
  public function fetch($number)
 {
        throw new RequestException('Fetching messages from PlayMobile Gateway not supported.');
 }

  public function getClient() {
      return $this->client;
  }

}