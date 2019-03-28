<?php
/**
 * Copyright (c) 2019 Florian Levis.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace Gounlaf\VwsApiClient\Impl\Model;

use Gounlaf\VwsApiClient\Contracts\Model\TargetRecord as Contract;

class TargetRecord implements Contract
{
    /**
     * @var string
     */
    protected $targetId;

    /**
     * @var bool
     */
    protected $activeFlag;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var float
     */
    protected $width;

    /**
     * @var int
     */
    protected $trackingRating;

    /**
     * @var string
     */
    protected $recoRating;

    /**
     * @inheritDoc
     */
    public function getTargetId(): string
    {
        return $this->targetId;
    }

    /**
     * @inheritDoc
     */
    public function getActiveFlag(): bool
    {
        return $this->activeFlag;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function getWidth(): float
    {
        return $this->width;
    }

    /**
     * @inheritDoc
     */
    public function getTrackingRating(): int
    {
        return $this->trackingRating;
    }

    /**
     * @inheritDoc
     */
    public function getRecoRating(): string
    {
        return $this->recoRating;
    }
}
