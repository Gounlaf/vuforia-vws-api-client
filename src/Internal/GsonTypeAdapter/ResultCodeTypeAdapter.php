<?php
/**
 * Copyright (c) 2019 Florian Levis.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace Gounlaf\VwsApiClient\Internal\GsonTypeAdapter;

use Gounlaf\VwsApiClient\Contracts\Response\ResultCode;
use Tebru\Gson\JsonReadable;
use Tebru\Gson\JsonToken;
use Tebru\Gson\JsonWritable;
use Tebru\Gson\TypeAdapter;

final class ResultCodeTypeAdapter extends TypeAdapter
{
    /**
     * @inheritDoc
     *
     * @return ResultCode|null
     */
    public function read(JsonReadable $reader): ?ResultCode
    {
        if ($reader->peek() === JsonToken::NULL) {
            $reader->nextNull();
            return null;
        }

        return new ResultCode($reader->nextString());
    }

    /**
     * @inheritDoc
     *
     * @param null|ResultCode $value
     */
    public function write(JsonWritable $writer, $value): void
    {
        if (null === $value) {
            $writer->writeNull();
            return;
        }

        $writer->writeString((string)$value);
    }
}
