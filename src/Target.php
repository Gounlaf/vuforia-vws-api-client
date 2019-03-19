<?php
/**
 * Copyright (c) 2019 Florian Levis.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace Gounlaf\VfsApiClient;

use Gounlaf\Psr7streams\ConvertBase64EncodeStream;
use GuzzleHttp\Psr7\Stream;
use function GuzzleHttp\Psr7\stream_for;
use Psr\Http\Message\StreamInterface;

final class Target extends Stream
{
    /**
     * @param string $name
     * @param float $width
     * @param StreamInterface $image
     * @param bool $activeFlag
     * @param StreamInterface $applicationMetadata
     */
    public function __construct(
        string $name,
        float $width,
        StreamInterface $image,
        bool $activeFlag,
        StreamInterface $applicationMetadata
    )
    {
        $imageStream = new ConvertBase64EncodeStream($image);
        $applicationMetadataStream = new ConvertBase64EncodeStream($applicationMetadata);

        $data = \GuzzleHttp\json_encode([
            'name' => $name,
            'width' => $width,
            'image' => (string)$imageStream,
            'active_flag' => $activeFlag,
            'application_metadata' => (string)$applicationMetadataStream,
        ]);

        return parent::__construct(stream_for($data)->detach(), ['size' => strlen($data)]);
    }
}
