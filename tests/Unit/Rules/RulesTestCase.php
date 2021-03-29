<?php

namespace Tests\Unit\Rules;

use App\Support\ArrayFormat;
use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Validator;
use PHPUnit\Framework\TestCase;

abstract class RulesTestCase extends TestCase
{

    protected Validator $validator;

    /**
     * @{inheritdoc}
     */
    public function setUp(): void
    {
        parent::setUp();
        $loader = new ArrayLoader();
        $translator = new Translator($loader, 'en');
        $this->validator = new Validator($translator, [], []);
    }

}
