<?php
/**
 * Copyright (c) 2019 Florian Levis.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace Gounlaf\VwsApiClient\Contracts\Model;

interface SimpleResponseBody
{
    /**
     * One of the VWS API Result Codes
     *
     * @see ResultCode
     *
     * @return string
     */
    public function getResultCode(): string;

    /**
     * ID of the transaction
     *
     * @return string
     */
    public function getTransactionId(): string;
}
