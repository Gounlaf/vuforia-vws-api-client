<?php
/**
 * Copyright (c) 2019 Florian Levis.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace Gounlaf\VwsApiClient\Impl\Model;

use Gounlaf\VwsApiClient\Contracts\Model\ResultCode;
use Gounlaf\VwsApiClient\Contracts\Model\SimpleResponseBody as Contract;

abstract class SimpleResponseBody implements Contract
{
    /**
     * @see ResultCode
     *
     * @var string
     */
    protected $resultCode;

    /**
     * @var string
     */
    protected $transactionId;

    /**
     * @inheritDoc
     */
    public function getResultCode(): string
    {
        return $this->resultCode;
    }

    /**
     * @inheritDoc
     */
    public function getTransactionId(): string
    {
        return $this->transactionId;
    }
}
