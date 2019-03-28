<?php
/**
 * Copyright (c) 2019 Florian Levis.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace Gounlaf\VwsApiClient\Contracts\Model;

interface GetTargetResponseBody extends SimpleResponseBody
{
    /**
     * Status of the target; current supported values are processing, success, and failed
     *
     * @return string
     */
    public function getStatus(): string;

    /**
     * Contains a target record at the TMS
     *
     * @return TargetRecord
     */
    public function getTargetRecord(): TargetRecord;
}
