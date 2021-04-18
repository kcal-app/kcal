<?php

namespace Tests\Unit\Rules;

use App\Rules\StringIsPositiveDecimalOrFraction;

class StringIsPositiveDecimalOrFractionTest extends RulesTestCase
{

    /**
     * @{inheritdoc}
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->validator->setRules([new StringIsPositiveDecimalOrFraction()]);
    }

    /**
     * Test string is decimal or faction rule with failing values.
     *
     * @dataProvider invalidDecimalsAndFractions
     *
     * @see \App\Rules\InArray
     */
    public function testStringIsDecimalOrFractionRuleFails(mixed $value): void
    {
        $this->validator->setData([$value]);
        $this->assertFalse($this->validator->passes());
    }

    /**
     * Test string is decimal or faction rule with passing values.
     *
     * @dataProvider validDecimalsAndFractions
     *
     * @see \App\Rules\InArray
     */
    public function testStringIsDecimalOrFractionRulePasses(mixed $value): void
    {
        $this->validator->setData([$value]);
        $this->assertTrue($this->validator->passes());
    }

    /**
     * Data providers.
     */

    /**
     * Provide valid decimals or fractions
     *
     * @see \Tests\Unit\Rules\StringIsPositiveDecimalOrFractionTest::testStringIsDecimalOrFractionRule()
     */
    public function invalidDecimalsAndFractions(): array {
        return [['-1'], [-1], ['0'], [0], ['string']];
    }

    /**
     * Provide valid decimals or fractions
     *
     * @see \Tests\Unit\Rules\StringIsPositiveDecimalOrFractionTest::testStringIsDecimalOrFractionRule()
     */
    public function validDecimalsAndFractions(): array {
        return [
            ['0.5'], ['1'], ['1.25'], ['1 1/2'], ['2 2/3'],
            [1/3], [1], [2.5]
        ];
    }

}
