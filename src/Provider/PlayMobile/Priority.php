<?php

namespace Kibernika\SMS\Provider\PlayMobile;


class Priority
{
    const LOW = "low";
    const NORMAL = "normal";
    const HIGH = "high";
    const REALTIME = "realtime";

    public static function isPriority($priority)
    {
        return  in_array($priority, [self::LOW, self::NORMAL, self::HIGH, self::REALTIME ], true);
    }
}