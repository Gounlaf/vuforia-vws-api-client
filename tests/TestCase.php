<?php
/**
 * Copyright (c) 2019 Florian Levis.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace Gounlaf\VwsApiClient\Test;

use Carbon\Carbon;
use Carbon\CarbonImmutable;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    protected function tearDown(): void
    {
        parent::tearDown();
        Carbon::setTestNow(null);
        CarbonImmutable::setTestNow(null);
    }
}
