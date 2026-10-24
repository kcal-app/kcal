<?php

namespace Tests\Unit\Rules;

use App\Rules\StringIsPositiveDecimalOrFraction;
use PHPUnit\Framework\Attributes\DataProvider;

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
     * @see \App\Rules\InArray
     */
    #[DataProvider('invalidDecimalsAndFractions')]
    public function testStringIsDecimalOrFractionRuleFails(mixed $value): void
    {
        $this->validator->setData([$value]);
        $this->assertFalse($this->validator->passes());
    }

    /**
     * Test string is decimal or faction rule with passing values.
     *
     * @see \App\Rules\InArray
     */
    #[DataProvider('validDecimalsAndFractions')]
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
    public static function invalidDecimalsAndFractions(): array {
        return [['-1'], [-1], ['0'], [0], ['string']];
    }

    /**
     * Provide valid decimals or fractions
     *
     * @see \Tests\Unit\Rules\StringIsPositiveDecimalOrFractionTest::testStringIsDecimalOrFractionRule()
     */
    public static function validDecimalsAndFractions(): array {
        return [
            ['0.5'], ['1'], ['1.25'], ['1 1/2'], ['2 2/3'],
            [1/3], [1], [2.5]
        ];
    }

}
