<?php

namespace Tests\Unit\Support;

use App\Support\Nutrients;
use PHPUnit\Framework\TestCase;

class NutrientsTest extends TestCase
{

    /**
     * Test nutrient rounding.
     *
     * @dataProvider nutrientAmountsProvider
     *
     * @see \App\Support\Nutrients::round()
     */
    public function testNutrientRounding(float $amount, string $nutrient, float $expectedFloat): void
    {
        $result = Nutrients::round($amount, $nutrient);
        $this->assertIsFloat($result);
        $this->assertEquals($expectedFloat, $result);
    }

    public function testNutrientRoundingExcepts(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Nutrients::round(1, 'pancake');
    }

    /**
     * Data providers.
     */

    /**
     * Provide nutrient amounts for and expected rounded results.
     */
    public function nutrientAmountsProvider(): array {
        return [
            [0, 'calories', 0], [1, 'calories', 0], [2, 'calories', 0], [3, 'calories', 0], [4, 'calories', 0], [5, 'calories', 5], [21, 'calories', 20], [23, 'calories', 25], [45, 'calories', 45], [50, 'calories', 50],
            [0, 'carbohydrates', 0], [0.1, 'carbohydrates', 0], [0.2, 'carbohydrates', 0], [0.3, 'carbohydrates', 0], [0.4, 'carbohydrates', 0], [0.5, 'carbohydrates', 0], [0.9, 'carbohydrates', 0], [1, 'carbohydrates', 1], [2.25, 'carbohydrates', 2], [2.75, 'carbohydrates', 3],
            [0, 'protein', 0], [0.1, 'protein', 0], [0.2, 'protein', 0], [0.3, 'protein', 0], [0.4, 'protein', 0], [0.5, 'protein', 0], [0.9, 'protein', 0], [1, 'protein', 1], [2.25, 'protein', 2], [2.75, 'protein', 3],
            [0, 'cholesterol', 0], [0.1, 'cholesterol', 0], [0.2, 'cholesterol', 0], [0.3, 'cholesterol', 0], [0.4, 'cholesterol', 0], [0.5, 'cholesterol', 0.5], [0.9, 'cholesterol', 1], [1, 'cholesterol', 1], [1.2, 'cholesterol', 1], [1.4, 'cholesterol', 1.5], [5, 'cholesterol', 5], [6, 'cholesterol', 6], [6.25, 'cholesterol', 6], [6.75, 'cholesterol', 7],
            [0, 'fat', 0], [0.1, 'fat', 0], [0.2, 'fat', 0], [0.3, 'fat', 0], [0.4, 'fat', 0], [0.5, 'fat', 0.5], [0.9, 'fat', 1], [1, 'fat', 1], [1.2, 'fat', 1], [1.4, 'fat', 1.5], [5, 'fat', 5], [6, 'fat', 6], [6.25, 'fat', 6], [6.75, 'fat', 7],
            [0, 'sodium', 0], [1, 'sodium', 0], [2, 'sodium', 0], [3, 'sodium', 0], [4, 'sodium', 0], [5, 'sodium', 5], [6, 'sodium', 5], [7, 'sodium', 5], [8, 'sodium', 10], [9, 'sodium', 10], [10, 'sodium', 10], [139, 'sodium', 140], [140, 'sodium', 140], [146, 'sodium', 150], [151, 'sodium', 150], [159, 'sodium', 160],
        ];
    }
}
