<?php
/**
 * Copyright (c) 2019 Florian Levis.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace Gounlaf\VwsApiClient\Contracts\Response\Body;

interface AddTargetResponseBody extends SimpleResponseBody
{
    /**
     * @return string
     */
    public function getTargetId(): string;
}
