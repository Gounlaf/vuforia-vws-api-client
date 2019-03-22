<?php
/**
 * Copyright (c) 2019 Florian Levis.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace Gounlaf\VwsApiClient;

use GuzzleHttp\Psr7\Stream;
use function GuzzleHttp\Psr7\stream_for;
use Psr\Http\Message\StreamInterface;

final class Target extends Stream
{
    /**
     * @param string $name
     * @param float $width
     * @param StreamInterface $image Base64 encoded version of your image
     * @param bool $activeFlag
     * @param StreamInterface $applicationMetadata Base64 encoded version of your metadata
     */
    public function __construct(
        string $name,
        float $width,
        StreamInterface $image,
        bool $activeFlag,
        StreamInterface $applicationMetadata
    )
    {
        $data = \GuzzleHttp\json_encode([
            'name' => $name,
            'width' => $width,
            'image' => (string)$image,
            'active_flag' => $activeFlag,
            'application_metadata' => (string)$applicationMetadata,
        ]);

        return parent::__construct(stream_for($data)->detach(), ['size' => strlen($data)]);
    }
}
