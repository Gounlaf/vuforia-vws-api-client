<?php
/**
 * Copyright (c) 2019 Florian Levis.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace Gounlaf\VwsApiClient\Impl\Response\Body;

use Gounlaf\VwsApiClient\Contracts\Response\Body\AddTargetResponseBody as Contract;

class AddTargetResponseBody extends SimpleResponseBody implements Contract
{
    /**
     * @var string
     */
    protected $targetId;

    /**
     * @return string
     */
    public function getTargetId(): string
    {
        return $this->targetId;
    }
}
