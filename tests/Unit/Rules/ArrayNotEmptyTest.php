<?php

namespace Tests\Unit\Rules;

use App\Rules\ArrayNotEmpty;

class ArrayNotEmptyTest extends RulesTestCase
{

    /**
     * Test array not empty rule.
     *
     * @see \App\Rules\ArrayNotEmpty
     */
    public function testArrayNotEmptyRule(): void
    {
        $this->validator->setRules([new ArrayNotEmpty()]);
        $this->validator->setData([['item']]);
        $this->assertTrue($this->validator->passes());
        $this->validator->setData([[]]);
        $this->assertFalse($this->validator->passes());
    }

}
