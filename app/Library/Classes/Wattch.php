<?php

namespace App\Library\Classes;

use PHPUnit\Framework\Assert;

class Wattch
{
    public static function assertTrue($value)
    {
        try {
            Assert::assertTrue($value);

            return 'Success';
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    public static function assertContains($needle, $value)
    {
        try {
            Assert::assertContains($needle, $value);

            return 'Success';
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
}
