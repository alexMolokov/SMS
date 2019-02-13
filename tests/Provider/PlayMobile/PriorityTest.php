<?php
use PHPUnit\Framework\TestCase;
use Kibernika\SMS\Provider\PlayMobile\Priority;

class PriorityTest extends TestCase
{


    public function dataProvider() {
        return [
          [0, false],
          [-1, false],
          [Priority::NORMAL, true]  ,
          [Priority::NORMAL . "  ", false]  ,
        ];
    }

    /**
     * @dataProvider dataProvider
     *
     */
    public function testIsPriority($priority, $expected) {
        $result = Priority::isPriority($priority);
        $this->assertEquals($expected, $result);
    }
}