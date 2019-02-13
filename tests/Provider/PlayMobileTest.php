<?php

use Kibernika\SMS\Provider\PlayMobile\Config;
use Kibernika\SMS\Provider\PlayMobile;
use Kibernika\SMS\Provider\PlayMobile\Priority;
use Kibernika\SMS\Provider\ClientFactory;
use Kibernika\SMS\Message;
use Kibernika\SMS\Exception\RequestException;

use GuzzleHttp\ClientInterface;

class PlayMobileTest extends \PHPUnit\Framework\TestCase
{

    public function setUp()
    {
        ClientFactory::reset();
    }

    public function testConstruct() {
        $config = new Config(["login" => "login", "password" => "password", "url" => "url", "timeout" => 10]);
        $client = $this->createMock(ClientInterface::class);
        ClientFactory::setClient($client);
        $provider = new PlayMobile($config);
        $this->assertSame($client, $provider->getClient());
    }

    public function priorityInvalidDataProvider(){
        return [
            "with-space" => [Priority::LOW . " "],
            "zero" => [0],
            "zero-string" => ["0"],
            "null" => [null],
            "space-first" => [" " . Priority::REALTIME],
            "space-priority-space" => [" " . Priority::REALTIME . " "],
            "true" => [true],
            "false" => [false],
            "stdClass" => [new stdClass()]
        ];
    }
    /**
     * @dataProvider priorityInvalidDataProvider
     */
    public function testSetPriorityInvalidValue($priority)
    {
        $config = new Config(["login" => "login", "password" => "password", "url" => "url", "timeout" => 10]);
        $provider = new PlayMobile($config);
        $this->expectException(\InvalidArgumentException::class);
        $provider->setPriority($priority);
    }

    public function priorityDataProvider(){
        return [
            "low" => [Priority::LOW],
            "normal" => [Priority::NORMAL],
            "high" => [Priority::HIGH],
            "realtime" => [Priority::REALTIME]
        ];
    }

    /**
     * @dataProvider  priorityDataProvider
     */
    public function testSetPriorityValidValue($priority) {
        $config = new Config(["login" => "login", "password" => "password", "url" => "url", "timeout" => 10]);
        $provider = new PlayMobile($config);
        $provider->setPriority($priority);
        $this->assertEquals($priority, $provider->getPriority());
    }

    public function sendSuccessDataProvider(){
        return [
            "ok" => [200, true],
        ];
    }

    public function sendInvalidDataProvider(){
        return [
            "error" => [400, false, [], '{"error_code": ' . PlayMobile\Error::TOO_MUCH_IDS . ', "error_description": "too much ids"}'],
            "auth-error" => [400, false, [], '{"error_code": ' . PlayMobile\Error::ACCOUNT_LOCK . ', "error_description": "account lock"}']
        ];
    }

    /**
     * @dataProvider  sendInvalidDataProvider
     * @dataProvider  sendSuccessDataProvider
     */
    public function testSend($status, $success) {
        //GuzzleHttp\Psr7\Response

       $config = new Config(["login" => "login", "password" => "password", "url" => "url", "timeout" => 10]);
       $message = new Message("79035481251", "smsSender", "All is OK", []);
       $sms = [
            "priority" => Priority::NORMAL,
            "sms" => [
                "originator" =>  $message->getFrom(),
                "content" =>  ["text" =>  $message->getMessageText()]
            ],
            "messages" => [
                "recipient" => $message->getTo()

            ]
        ];
        $data = [
            "auth" =>  [
                $config->getLogin(),
                $config->getPassword()
            ],
            'json' => $sms
        ];

       $client = $this->getMockBuilder(ClientInterface::class)->getMock();
        $client->expects($this->once())
            ->method('request')
            ->with($this->equalTo("POST"), $this->equalTo("send"), $this->equalTo($data))
            ->willReturn(new GuzzleHttp\Psr7\Response($status));

        ClientFactory::setClient($client);

        $provider = new PlayMobile($config);
        $response = $provider->send($message);

        $this->assertSame($success, $response->wasSuccessful());
    }

    /**
     *  @dataProvider  sendInvalidDataProvider
     */
    public function testSendGetInvalidResponse($status, $success, $headers, $body)
    {
        $client = $this->getMockBuilder(ClientInterface::class)->getMock();
        $client->expects($this->once())
            ->method('request')
            ->willReturn(new GuzzleHttp\Psr7\Response($status,$headers, $body));

        ClientFactory::setClient($client);
        $provider = new PlayMobile($this->getConfig());
        $response = $provider->send($this->getMessage());

        $body = json_decode($body);

        $this->assertEquals($body->error_code, $response->getResponseCode());
        $this->assertEquals($body->error_description, $response->getResponseMessage());
    }

    private function getConfig() {
        return new Config(["login" => "login", "password" => "password", "url" => "url", "timeout" => 10]);
    }

    private function getMessage(){
        return new Message("79035481251", "smsSender", "All is OK", []);
    }

    public function testSendWithException() {
        $config = new Config(["login" => "login", "password" => "password", "url" => "url", "timeout" => 10]);
        $client = $this->getMockBuilder(ClientInterface::class)->getMock();
        $errorMessage = "don't connect";
        $client->method("request")->will($this->throwException(new \Exception($errorMessage)));
        ClientFactory::setClient($client);
        $provider = new PlayMobile($config);
        //$this->expectException(RequestException::class);
        try {
            $provider->send(new Message("79035481251", "smsSender", "All is OK", []));
            $this->assertTrue(false);
        } catch(RequestException $e) {
            $this->assertEquals($errorMessage, $e->getMessage());
        }
    }

    public function testFetch() {
        $this->expectException(RequestException::class);
        $provider = new PlayMobile($this->getConfig());
        $provider->fetch(6);
    }



}