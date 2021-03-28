<?php

namespace Tests\Unit\Support;

use App\Support\ArrayFormat;
use PHPUnit\Framework\TestCase;

class ArrayFormatTest extends TestCase
{

    /**
     * Test input array "flipping".
     *
     * @see \App\Support\ArrayFormat::flipTwoDimensionalKeys()
     */
    public function testFlipTwoDimensionalKeys(): void
    {
        $input = [
            'ingredient' => [
                0 => 'ingredient-0',
                1 => 'ingredient-1',
                2 => 'ingredient-2',
                3 => 'ingredient-3',
            ],
            'amount' => [
                0 => 'amount-0',
                1 => 'amount-1',
                2 => 'amount-2',
                3 => 'amount-3',
            ],
        ];
        $expected = [
            ['ingredient' => 'ingredient-0', 'amount' => 'amount-0'],
            ['ingredient' => 'ingredient-1', 'amount' => 'amount-1'],
            ['ingredient' => 'ingredient-2', 'amount' => 'amount-2'],
            ['ingredient' => 'ingredient-3', 'amount' => 'amount-3'],
        ];
        $this->assertEqualsCanonicalizing($expected, ArrayFormat::flipTwoDimensionalKeys($input));
    }
}
