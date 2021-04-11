<?php

namespace App\Support;

use Phospr\Fraction;

class Number
{
    /**
     * Get a float value from a decimal or rational string.
     *
     * @param string $value
     *   Decimal or rational string.
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
     * Get a string rational representation of a float.
     *
     * Special handling is used for common cases 1/3 and 2/3 to ensure the
     * expected rationals. Other less common rationals (e.g. n/7 or n/9) will
     * not be well handled here.
     *
     * @param float $value
     *   Value to convert to rational string.
     * @return string
     *   Rational string.
     *
     * @todo Learn maths.
     */
    public static function rationalStringFromFloat(float $value): string {
        $decimal = Fraction::fromFloat(($value - floor($value)));
        if ($decimal->isSameValueAs(Fraction::fromFloat(1/3))) {
            $string = '1/3';
            $whole = floor($value);
            if ($whole > 0) {
                $string = "{$whole} {$string}";
            }
        }
        elseif ($decimal->isSameValueAs(Fraction::fromFloat(2/3))) {
            $string = '2/3';
            $whole = floor($value);
            if ($whole > 0) {
                $string = "{$whole} {$string}";
            }
        }
        else {
            $string = (string) Fraction::fromFloat($value);
        }
        return $string;
    }
}
