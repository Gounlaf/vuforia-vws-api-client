<?php
/**
 * Copyright (c) 2019 Florian Levis.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace Gounlaf\VwsApiClient\Impl\Model;

use Gounlaf\VwsApiClient\Contracts\Model\GetTargetResponseBody as Contract;
use Gounlaf\VwsApiClient\Contracts\Model\TargetRecord;
use Tebru\Gson\Annotation as Gson;

class GetTargetResponseBody extends SimpleResponseBody implements Contract
{
    /**
     * @var string
     */
    protected $status;

    /**
     * @Gson\Type("Gounlaf\VwsApiClient\Impl\Model\TargetRecord")
     *
     * @var TargetRecord
     */
    protected $targetRecord;

    /**
     * @inheritDoc
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @inheritDoc
     */
    public function getTargetRecord(): TargetRecord
    {
        return $this->targetRecord;
    }
}
