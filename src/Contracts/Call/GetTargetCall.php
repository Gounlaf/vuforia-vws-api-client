<?php
/**
 * Copyright (c) 2019 Florian Levis.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace Gounlaf\VwsApiClient\Contracts\Call;

use Gounlaf\VwsApiClient\Contracts\Response\Body\GetTargetResponse;
use Tebru\Retrofit\Call;

/**
 * @method GetTargetResponse execute()
 */
interface GetTargetCall extends Call
{
}
