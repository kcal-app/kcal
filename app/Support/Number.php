<?php

namespace App\Support;

use Phospr\Fraction;

class Number
{
    /**
     * Get a float value from a decimal or fraction string.
     *
     * @param string $value
     *   Value in decimal or string format.
     * @return float
     *   Float representation of the value.
     *
     * @throws \InvalidArgumentException
     */
    public static function floatFromString(string $value): float {
        if ((float) $value == $value) {
            $result = (float) $value;
        }
        else {
            $result = Fraction::fromString($value)->toFloat();
        }
        return $result;
    }

    /**
     * Get a string faction representation of a float.
     *
     * @todo Handle repeating values like 1/3, 2/3, etc. better.
     *
     * @see https://rosettacode.org/wiki/Convert_decimal_number_to_rational#PHP
     *
     * @param float $value
     *   Value to convert to string fraction.
     * @return string
     *   String fraction.
     */
    public static function fractionStringFromFloat(float $value): string {
        $fraction = (string) Fraction::fromFloat($value);
        $fraction = str_replace(['33/100', '33333333/100000000'], '1/3', $fraction);
        $fraction = str_replace(['67/100', '66666667/100000000'], '2/3', $fraction);
        return $fraction;
    }
}
