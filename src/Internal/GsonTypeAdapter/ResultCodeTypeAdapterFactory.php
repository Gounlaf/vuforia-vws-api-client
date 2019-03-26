<?php
/**
 * Copyright (c) 2019 Florian Levis.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace Gounlaf\VwsApiClient\Internal\GsonTypeAdapter;

use Tebru\Gson\Internal\TypeAdapterProvider;
use Tebru\Gson\TypeAdapter;
use Tebru\Gson\TypeAdapterFactory;
use Tebru\PhpType\TypeToken;

final class ResultCodeTypeAdapterFactory implements TypeAdapterFactory
{
    /**
     * @inheritDoc
     */
    public function supports(TypeToken $type): bool
    {
        return $type->isString();
    }

    /**
     * @inheritDoc
     */
    public function create(TypeToken $type, TypeAdapterProvider $typeAdapterProvider): TypeAdapter
    {
        return new ResultCodeTypeAdapter();
    }
}
