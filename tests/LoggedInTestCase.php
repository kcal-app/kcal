<?php

namespace Tests;

abstract class LoggedInTestCase extends TestCase
{
    use LogsIn;

    public function setUp(): void
    {
        parent::setUp();
        $this->loginUser();
    }

}
