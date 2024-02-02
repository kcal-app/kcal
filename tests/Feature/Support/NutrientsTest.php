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
    public function recipesValidRecipeNutrientAmountsProvider(): array {
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
    public function foodsInvalidNutrientMultipliersProvider(): array {
        $this->refreshApplication();

        /** @var \App\Models\Food $foodInvalidUnit */
        $foodInvalidUnit = Food::factory()->make(['serving_unit' => 'invalid']);

        return [
            [$foodInvalidUnit, 1, 'tsp'],
            [$foodInvalidUnit, 1, 'tbsp'],
            [$foodInvalidUnit, 1, 'cup'],
            [Food::factory()->make(['serving_unit' => 'tsp', 'serving_size' => 1]), 1, 'invalid'],
        ];
    }

    /**
     * Provide example foods and expected nutrient multipliers.
     */
    public function foodsValidNutrientMultipliersProvider(): array {
        $this->refreshApplication();

        /** @var \App\Models\Food[] $foods */
        $foods = [
            'tsp' => Food::factory()->make(['serving_unit' => 'tsp', 'serving_size' => 1]),
            'tbsp' => Food::factory()->make(['serving_unit' => 'tbsp', 'serving_size' => 1]),
            'cup' => Food::factory()->make(['serving_unit' => 'cup', 'serving_size' => 1]),
            'none' => Food::factory()->make(['serving_unit' => null, 'serving_unit_name' => 'head']),
        ];

        return [
//            [$foods['tsp'], $foods['tsp']->serving_weight, 'oz', Nutrients::$gramsPerOunce],
            [$foods['tsp'], 1, 'serving', 1],
            [$foods['tsp'], $foods['tsp']->serving_weight * 1.5, 'gram', 1.5],
            [$foods['tsp'], 2, 'tsp', 2],
            [$foods['tsp'], 1, 'tbsp', 3],
            [$foods['tsp'], 1, 'cup', 48],
//            [$foods['tbsp'], $foods['tbsp']->serving_weight, 'oz', Nutrients::$gramsPerOunce],
            [$foods['tbsp'], 1, 'serving', 1],
            [$foods['tbsp'], $foods['tbsp']->serving_weight * 2, 'gram', 2],
            [$foods['tbsp'], 2, 'tsp', 2/3],
            [$foods['tbsp'], 1, 'tbsp', 1],
            [$foods['tbsp'], 2, 'cup', 32],
//            [$foods['cup'], $foods['cup']->serving_weight, 'oz', Nutrients::$gramsPerOunce],
            [$foods['cup'], 1, 'serving', 1],
            [$foods['cup'], $foods['cup']->serving_weight * 2.25, 'gram', 2.25],
            [$foods['cup'], 3, 'tsp', 1/16],
            [$foods['cup'], 2, 'tbsp', 1/8],
            [$foods['cup'], 5, 'cup', 5],
//            [$foods['none'], $foods['none']->serving_weight, 'oz', Nutrients::$gramsPerOunce],
            [$foods['none'], 1, 'serving', 1],
            [$foods['none'], $foods['none']->serving_weight * 3.0125, 'gram', 3.0125],
        ];
    }
}
