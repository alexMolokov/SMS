<?php

use Kibernika\SMS\Message;
use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase
{

    private $recipient;
    private $to;
    private $text;
    private $options;

    public function setUp(){
        $this->recipient = "+79035481254";
        $this->from = "Kibernika";
        $this->text = "text";
        $this->options = ["first" => "ok"];
    }

    public function testSetIsSuccess()
    {

        $message = new Message($this->recipient, $this->from, $this->text, $this->options);
        $this->assertEquals($this->recipient, $message->getTo());
        $this->assertEquals($this->from, $message->getFrom());
        $this->assertEquals($this->text, $message->getMessageText());
        $this->assertEquals($this->options, $message->getOptions());
    }

    public function testConstructorWithNulldRecipient() {
        $this->expectException('\InvalidArgumentException');
        new Message(null, $this->from, $this->text);
    }

    public function testConstructorWithNullSender() {
        $this->expectException('\InvalidArgumentException');
        new Message($this->recipient, null, $this->text);
    }

    public function testConstructorWithNullText() {
        $this->expectException('\InvalidArgumentException');
        new Message($this->recipient,  $this->from, null);
    }


    public function testConstructorWithNullsArguments() {
        $this->expectException('\InvalidArgumentException');
        new Message(null, null, null);
    }

    public function testSetRecipientNull()
    {
        $message = new Message($this->recipient,  $this->from, $this->text);
        $this->expectException('\InvalidArgumentException');
        $message->setTo(null);
    }

    public function testSetSenderNull()
    {
        $message = new Message($this->recipient,  $this->from, $this->text);
        $this->expectException('\InvalidArgumentException');
        $message->setFrom(null);
    }


    public function testSetTextNull()
    {
        $message = new Message($this->recipient,  $this->from, $this->text);
        $this->expectException('\InvalidArgumentException');
        $message->setMessageText(null);
    }


    public function testSetTIme()
    {
        $message = new Message($this->recipient,  $this->from, $this->text);
        $time = new \DateTime();
        $message->setTime($time);
        $this->assertEquals($time, $message->getTime());
    }



}