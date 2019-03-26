<?php
/**
 * Copyright (c) 2019 Florian Levis.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace Gounlaf\VwsApiClient\Contracts\Response\Body;

use Gounlaf\VwsApiClient\Contracts\Response\ResultCode;

interface SimpleResponseBody
{
    /**
     * @return ResultCode
     */
    public function getResultCode(): ResultCode;

    /**
     * @return string
     */
    public function getTransactionId(): string;
}
