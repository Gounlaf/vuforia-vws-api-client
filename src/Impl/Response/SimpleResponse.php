<?php
/**
 * Copyright (c) 2019 Florian Levis.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace Gounlaf\VfsApiClient\Impl\Response;

use Gounlaf\VfsApiClient\Contracts\Response\SimpleResponse as Contract;

class SimpleResponse implements Contract
{
    /**
     * @var string
     */
    protected $resultCode;

    /**
     * @var string
     */
    protected $transactionId;

    /**
     * @return string
     */
    public function getResultCode(): string
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
