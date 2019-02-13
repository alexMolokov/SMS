<?php
use Kibernika\SMS\Gateway;
use Kibernika\SMS\Message;
use Kibernika\SMS\Provider\ProviderInterface;

use PHPUnit\Framework\TestCase;

class GatewayTest extends TestCase
{


    
    public function setUp() {


    }

    public function testConstructorInjection()
    {
        $stubProvider = $this->createMock(ProviderInterface::class);

        $gateway = new Gateway(
            $stubProvider,
            true
        );
        $this->assertInstanceOf('\\Kibernika\\SMS\\Gateway', $gateway);
    }

    public function testConstructorFailsIfDebugModeTypeIsNotBool()
    {
        $stubProvider = $this->createMock(ProviderInterface::class);

        $this->expectException('InvalidArgumentException');
        new Gateway(
            $stubProvider,
            'ABC'
        );
    }

    public function notIntDataProvider() {
      return [
          "string" => ['ABC'],
          "float" => [4.02],
          "zero" => [0],
          "negative" => [-10],
          "boolean-true" => [true],
          "boolean-false" => [false]
      ];
    }

    /**
     * @dataProvider notIntDataProvider
     */
    public function testFetchInvalidArgument($number)
    {
        $stubProvider = $this->createMock(ProviderInterface::class);

       $this->expectException('InvalidArgumentException');
        $gateway = new Gateway(
            $stubProvider,
            true
        );
        $gateway->fetch($number);
    }


    public function testSend() {

        $message = new Message("79035481252", "Kibernika", "textText", ["ok" => true]);
        $debug = true;

        $provider = $this->getMockBuilder(ProviderInterface::class)
                           ->getMock();

        $provider->expects($this->once())
            ->method('send')
            ->with($this->equalTo($message), $this->equalTo($debug));

        $gateway = new Gateway(
            $provider,
            $debug
        );

        $gateway->send($message);
    }

    public function testFetch()
    {
        $number = 10;

        $provider = $this->getMockBuilder(ProviderInterface::class)
            ->getMock();

        $provider->expects($this->once())
            ->method('fetch')
            ->with($this->equalTo($number));

        $gateway = new Gateway(
            $provider,
            true
        );

        $gateway->fetch($number);

    }




}