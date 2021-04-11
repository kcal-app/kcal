<?php

namespace Tests\Feature\Support;

use App\Models\Food;
use App\Support\Nutrients;
use Tests\TestCase;

class NutrientsTest extends TestCase
{

    /**
     * Test invalid Food nutrient multiplier calculation.
     *
     * @dataProvider foodsInvalidNutrientMultipliersProvider
     */
    public function testCalculateFoodInvalidNutrientMultiplier(
        Food $food,
        float $amount,
        string $fromUnit,
    ): void {
        $this->expectException(\DomainException::class);
        Nutrients::calculateFoodNutrientMultiplier($food, $amount, $fromUnit);
    }

    /**
     * Test valid Food nutrient multiplier calculation.
     *
     * @dataProvider foodsValidNutrientMultipliersProvider
     */
    public function testCalculateFoodValidNutrientMultiplier(
        Food $food,
        float $amount,
        string $fromUnit,
        float $expectedMultiplier
    ): void {
        $this->assertEquals(
            Nutrients::calculateFoodNutrientMultiplier($food, $amount, $fromUnit),
            $expectedMultiplier
        );
    }

    /**
     * Data providers.
     */

    /**
     * Provide example foods and expected nutrient multipliers.
     */
    public function foodsInvalidNutrientMultipliersProvider(): array {
        $this->refreshApplication();

        /** @var \App\Models\Food $foodInvalidUnit */
        $foodInvalidUnit = Food::factory()->make(['serving_unit' => 'invalid']);

        return [
            [$foodInvalidUnit, 1, 'tsp'],
            [$foodInvalidUnit, 1, 'tbsp'],
            [$foodInvalidUnit, 1, 'cup'],
            [Food::factory()->tspServingUnit()->make(), 1, 'invalid'],
        ];
    }

    /**
     * Provide example foods and expected nutrient multipliers.
     */
    public function foodsValidNutrientMultipliersProvider(): array {
        $this->refreshApplication();

        /** @var \App\Models\Food[] $foods */
        $foods = [
            'tsp' => Food::factory()->tspServingUnit()->make(),
            'tbsp' => Food::factory()->tbspServingUnit()->make(),
            'cup' => Food::factory()->cupServingUnit()->make(),
            'none' => Food::factory()->noServingUnit()->make(),
        ];

        return [
            [$foods['tsp'], $foods['tsp']->serving_weight, 'oz', Nutrients::$gramsPerOunce],
            [$foods['tsp'], 1, 'serving', 1],
            [$foods['tsp'], $foods['tsp']->serving_weight * 1.5, 'gram', 1.5],
            [$foods['tsp'], 2, 'tsp', 2],
            [$foods['tsp'], 1, 'tbsp', 3],
            [$foods['tsp'], 1, 'cup', 48],
            [$foods['tbsp'], $foods['tbsp']->serving_weight, 'oz', Nutrients::$gramsPerOunce],
            [$foods['tbsp'], 1, 'serving', 1],
            [$foods['tbsp'], $foods['tbsp']->serving_weight * 2, 'gram', 2],
            [$foods['tbsp'], 2, 'tsp', 2/3],
            [$foods['tbsp'], 1, 'tbsp', 1],
            [$foods['tbsp'], 2, 'cup', 32],
            [$foods['cup'], $foods['cup']->serving_weight, 'oz', Nutrients::$gramsPerOunce],
            [$foods['cup'], 1, 'serving', 1],
            [$foods['cup'], $foods['cup']->serving_weight * 2.25, 'gram', 2.25],
            [$foods['cup'], 3, 'tsp', 1/16],
            [$foods['cup'], 2, 'tbsp', 1/8],
            [$foods['cup'], 5, 'cup', 5],
            [$foods['none'], $foods['none']->serving_weight, 'oz', Nutrients::$gramsPerOunce],
            [$foods['none'], 1, 'serving', 1],
            [$foods['none'], $foods['none']->serving_weight * 3.0125, 'gram', 3.0125],
        ];
    }
}
