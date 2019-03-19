<?php
/**
 * Copyright (c) 2019 Florian Levis.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace Gounlaf\VfsApiClient\Contracts\Call;

use Gounlaf\VfsApiClient\Contracts\Response\AddTargetResponse;
use Tebru\Retrofit\Call;

/**
 * @method AddTargetResponse execute()
 */
interface AddTargetCall extends Call
{
}