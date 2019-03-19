<?php
/**
 * Copyright (c) 2019 Florian Levis.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace Gounlaf\VfsApiClient\Contracts\Response;

interface SimpleResponse
{
    public function getResultCode(): string;

    public function getTransactionId(): string;
}
