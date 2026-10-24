<?php

namespace Tests\Feature\Support;

use App\Models\Food;
use App\Models\IngredientAmount;
use App\Models\Recipe;
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
        array $foodAttributes,
        float $amount,
        string $fromUnit,
    ): void {
        $food = Food::factory()->make($foodAttributes);
        $this->expectException(\DomainException::class);
        Nutrients::calculateFoodNutrientMultiplier($food, $amount, $fromUnit);
    }

    /**
     * Test valid Food nutrient multiplier calculation.
     *
     * @dataProvider foodsValidNutrientMultipliersProvider
     */
    public function testCalculateFoodValidNutrientMultiplier(
        ?string $servingUnit,
        float $amount,
        string $fromUnit,
        float $expectedMultiplier
    ): void {
        $food = Food::factory()->make([
            'serving_unit' => $servingUnit,
            'serving_size' => 1,
            'serving_weight' => 100,
        ]);
        $this->assertEquals(
            $expectedMultiplier,
            Nutrients::calculateFoodNutrientMultiplier($food, $amount, $fromUnit)
        );
    }

    /**
     * Test valid Recipe nutrient amount calculation.
     *
     * @dataProvider recipesValidRecipeNutrientAmountsProvider
     */
    public function testCalculateValidRecipeNutrientAmount(
        string $nutrient,
        float $amount,
        string $fromUnit,
        float $expectedAmount
    ): void {
        /** @var \App\Models\Recipe $recipe */
        $recipe = Recipe::factory()
            ->create(['volume' => 2, 'weight' => 400]);
        /** @var \App\Models\Food $food */
        $food = Food::factory()->create([
            'calories' => 20,
            'carbohydrates' => 20,
            'cholesterol' => 200,
            'fat' => 20,
            'protein' => 20,
            'sodium' => 200,
        ]);
        $ingredient = new IngredientAmount();
        $ingredient->fill([
            'amount' => 1,
            'unit' => 'serving',
            'weight' => 0,
        ])->ingredient()->associate($food);
        $recipe->ingredientAmounts()->save($ingredient);

        $this->assertEquals(
            $expectedAmount,
            Nutrients::calculateRecipeNutrientAmount($recipe, $nutrient, $amount, $fromUnit)
        );
    }

    /**
     * Data providers.
     */

    /**
     * Provide example recipe and expected nutrient amounts.
     */
    public static function recipesValidRecipeNutrientAmountsProvider(): array {
        return [
            ['calories', 1, 'cup', 10],
            ['calories', 2, 'cup', 20],
            ['carbohydrates', 8, 'tbsp', 5],
            ['carbohydrates', 16, 'tbsp', 10],
            ['cholesterol', 48, 'tsp', 100],
            ['cholesterol', 96, 'tsp', 200],
            ['fat', 100, 'gram', 5],
            ['fat', 200, 'gram', 10],
            ['protein', 100, 'gram', 5],
            ['protein', 200, 'gram', 10],
//            ['sodium', 2, 'oz', Nutrients::$gramsPerOunce],
//            ['sodium', 4, 'oz', Nutrients::$gramsPerOunce * 2],
        ];
    }

    /**
     * Provide example foods and expected nutrient multipliers.
     */
    public static function foodsInvalidNutrientMultipliersProvider(): array {
        return [
            [['serving_unit' => 'invalid'], 1, 'tsp'],
            [['serving_unit' => 'invalid'], 1, 'tbsp'],
            [['serving_unit' => 'invalid'], 1, 'cup'],
            [['serving_unit' => 'tsp', 'serving_size' => 1], 1, 'invalid'],
        ];
    }

    /**
     * Provide example foods and expected nutrient multipliers.
     */
    public static function foodsValidNutrientMultipliersProvider(): array {
        return [
            ['tsp', 1, 'serving', 1],
            ['tsp', 150, 'gram', 1.5],
            ['tsp', 2, 'tsp', 2],
            ['tsp', 1, 'tbsp', 3],
            ['tsp', 1, 'cup', 48],
            ['tbsp', 1, 'serving', 1],
            ['tbsp', 200, 'gram', 2],
            ['tbsp', 2, 'tsp', 2/3],
            ['tbsp', 1, 'tbsp', 1],
            ['tbsp', 2, 'cup', 32],
            ['cup', 1, 'serving', 1],
            ['cup', 225, 'gram', 2.25],
            ['cup', 3, 'tsp', 1/16],
            ['cup', 2, 'tbsp', 1/8],
            ['cup', 5, 'cup', 5],
            [null, 1, 'serving', 1],
            [null, 301.25, 'gram', 3.0125],
        ];
    }
}
