<?php
use Kibernika\SMS\Response;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    
    private $time;
    private $successful;
    private $code;
    private $message;
    
    public function setUp() {

        $this->time = time();
        $this->successful = true;
        $this->code = 10;
        $this->message = "OK";
    }

    public function testConstructorOk()
    {
        $instance = new Response($this->time, $this->successful, $this->code, $this->message);
        $this->assertEquals($this->time, $instance->getTstamp());
        $this->assertEquals($this->successful, $instance->wasSuccessful());
        $this->assertEquals($this->code, $instance->getResponseCode());
        $this->assertEquals($this->message, $instance->getResponseMessage());
        // calling constructor without arguments
        $this->expectException('PHPUnit_Framework_Error');
        new Response();
    }

    public function badTimeStampProvider()
    {
        return [
            'negative'  => [-10],
            'not-int' => [0.42],
            'string'  => ["s"],
            "empty" => [""],
            "null" => [null]
         ];
    }

    /**
     * @dataProvider badTimeStampProvider
     */
    public function testThrowsExceptionWithBadTstamp($timestamp)
    {
        $this->expectException(\InvalidArgumentException::class);
        new Response($timestamp, $this->successful, $this->code, $this->message);
    }


     public function testThrowsExceptionWithSuccessfulStateNotBool()
     {
           $successful = 'dr';
           $this->expectException(\InvalidArgumentException::class);
           new Response($this->time, $successful, $this->code, $this->message);
     }

}