<?php

namespace Tests\Unit\Rules;

use App\Models\Food;
use App\Models\User;
use App\Rules\UsesIngredientTrait;

class UsesIngredientTraitTest extends RulesTestCase
{

    /**
     * Test uses Ingredient trait rule.
     *
     * @see \App\Rules\UsesIngredientTrait
     */
    public function testUsesIngredientTraitRule(): void {
        $this->validator->setRules([new UsesIngredientTrait()]);
        $this->validator->setData([Food::class]);
        $this->assertTrue($this->validator->passes());
        $this->validator->setData([User::class]);
        $this->assertFalse($this->validator->passes());
    }
}
