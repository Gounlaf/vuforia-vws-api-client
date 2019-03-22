<?php
/**
 * Copyright (c) 2019 Florian Levis.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace Gounlaf\VwsApiClient\Test\Unit;

use Gounlaf\VwsApiClient\Target;
use Gounlaf\VwsApiClient\Test\TestCase;
use function GuzzleHttp\Psr7\stream_for;

final class TargetTest extends TestCase
{
    public function testTarget()
    {
        $target = new Target(
            'test',
            42.0,
            stream_for(base64_encode('image')),
            true,
            stream_for(base64_encode('application_metadata'))
        );

        $expectedJson = <<<'JSON'
{
  "name": "test",
  "width": 42.0,
  "image": "aW1hZ2U=",
  "active_flag": true,
  "application_metadata": "YXBwbGljYXRpb25fbWV0YWRhdGE="
}
JSON;

        $this->assertJsonStringEqualsJsonString($expectedJson, (string)$target);
    }
}
