<?php
use PHPUnit\Framework\TestCase;
use Kibernika\SMS\Provider\PlayMobile\Error;

class ErrorTest extends TestCase
{


    public function dataProvider() {
        return [
          [Error::INTERNAL_SERVER_ERROR , "Internal server error"],
          [-1, "Message for error code -1 not found"],
        ];
    }

    /**
     * @dataProvider dataProvider
     *
     */
    public function testIsPriority($code, $message) {
        $result = Error::getErrorMessage($code);

        $this->assertEquals($message, $result);
    }
}