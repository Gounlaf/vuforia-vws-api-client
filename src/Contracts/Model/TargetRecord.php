<?php
/**
 * Copyright (c) 2019 Florian Levis.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace Gounlaf\VwsApiClient\Contracts\Model;

interface TargetRecord
{
    /**
     * Target_id of the target
     *
     * @return string
     */
    public function getTargetId(): string;

    /**
     * Indicates whether or not the target is active for query; the default is true
     *
     * @return bool
     */
    public function getActiveFlag(): bool;

    /**
     * Name of the target; unique within a database
     *
     * @return string length [1-64]
     */
    public function getName(): string;

    /**
     * Width of the target in scene unit
     *
     * @return float
     */
    public function getWidth(): float;

    /**
     * Rating of the target recognition image for tracking purposes
     *
     * @return int [0-5]
     */
    public function getTrackingRating(): int;

    /**
     * Unused. Always contains an empty string
     * @return string
     */
    public function getRecoRating(): string;
}
