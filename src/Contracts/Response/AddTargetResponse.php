<?php
/**
 * Copyright (c) 2019 Florian Levis.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace Gounlaf\VwsApiClient\Contracts\Response\Body;

use Gounlaf\VwsApiClient\Contracts\Model\AddTargetResponseBody;
use Tebru\Retrofit\Response;

/**
 * @method AddTargetResponseBody body()
 */
interface AddTargetResponse extends Response
{
}
