<?php

namespace Tests\Unit\Support;

use App\Support\Number;
use PHPUnit\Framework\TestCase;

class NumberTest extends TestCase
{

    /**
     * Test float to string conversion.
     *
     * @dataProvider decimalStringFloatsProvider
     * @dataProvider fractionStringFloatsProvider
     *
     * @see \App\Support\Number::floatFromString()
     */
    public function testFloatFromString(string $string, float $expectedFloat): void
    {
        $result = Number::floatFromString($string);
        $this->assertIsFloat($result);
        $this->assertEquals($expectedFloat, $result);
    }

    /**
     * Test (fraction) string to float conversion.
     *
     * @dataProvider fractionStringFloatsProvider
     *
     * @see \App\Support\Number::fractionStringFromFloat()
     */
    public function testFractionStringFromFloat(string $expectedString, float $float): void
    {
        $result = Number::fractionStringFromFloat($float);
        $this->assertIsString($result);
        $this->assertEquals($expectedString, $result);
    }

    /**
     * Data providers.
     */

    /**
     * Provide decimal string and float data.
     *
     * @see \Tests\Unit\Support\NumberTest::testFloatFromString()
     */
    public function decimalStringFloatsProvider(): array {
        return [
            ['0.0', 0.0], ['0.125', 1/8], ['0.25', 1/4], ['0.5', 1/2],
            ['0.75', 3/4], ['1.0', 1.0], ['1.25', 1.25], ['1.5', 1.5],
            ['2.5', 2.5], ['2.75', 2.75],
        ];
    }

    /**
     * Provide fraction string and float data.
     *
     * @see \Tests\Unit\Support\NumberTest::testFloatFromString()
     * @see \Tests\Unit\Support\NumberTest::testFractionStringFromFloat()
     */
    public function fractionStringFloatsProvider(): array {
        return [
            ['0', 0.0], ['1/8', 1/8], ['1/4', 1/4], ['1/2', 1/2],
            ['3/4', 3/4], ['1', 1.0], ['1 1/4', 1.25],
            ['1 1/2', 1.5], ['2 1/2', 2.5], ['2 3/4', 2.75],
        ];
    }
}
