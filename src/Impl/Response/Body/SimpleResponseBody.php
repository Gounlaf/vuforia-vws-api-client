<?php
/**
 * Copyright (c) 2019 Florian Levis.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace Gounlaf\VwsApiClient\Impl\Response\Body;

use Gounlaf\VwsApiClient\Contracts\Response\Body\SimpleResponseBody as Contract;
use Gounlaf\VwsApiClient\Contracts\Response\ResultCode;
use Tebru\Gson\Annotation as Gson;

abstract class SimpleResponseBody implements Contract
{
    /**
     * @Gson\JsonAdapter("Gounlaf\VwsApiClient\Internal\GsonTypeAdapter\ResultCodeTypeAdapterFactory")
     *
     * @var ResultCode
     */
    protected $resultCode;

    /**
     * @var string
     */
    protected $transactionId;

    /**
     * @return ResultCode
     */
    public function getResultCode(): ResultCode
    {
        return $this->resultCode;
    }

    /**
     * @return string
     */
    public function getTransactionId(): string
    {
        return $this->transactionId;
    }
}
