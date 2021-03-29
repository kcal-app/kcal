<?php


namespace Tests\Unit\Rules;

use App\Rules\InArray;

class InArrayTest extends RulesTestCase
{

    /**
     * Test in array rule.
     *
     * @see \App\Rules\InArray
     */
    public function testInArrayRule(): void
    {
        $this->validator->setRules([new InArray(['item'])]);
        $this->validator->setData(['item']);
        $this->assertTrue($this->validator->passes());
        $this->validator->setData(['not item']);
        $this->assertFalse($this->validator->passes());
    }

}
