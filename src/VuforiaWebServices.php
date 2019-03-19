<?php
/**
 * Copyright (c) 2019 Florian Levis.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace Gounlaf\VfsApiClient;

use Gounlaf\VfsApiClient\Contracts\Call\AddTargetCall;
use Tebru\Retrofit\Annotation\Body;
use Tebru\Retrofit\Annotation\POST;
use Tebru\Retrofit\Annotation\ResponseBody;
use Tebru\Retrofit\Call;

interface VuforiaWebServices
{
    /**
     * @POST("/targets")
     * @Body("target")
     * @param Target $target
     * @ResponseBody("Gounlaf\VfsApiClient\Impl\Response\SimpleResponse")
     *
     * @return Call|AddTargetCall
     */
    public function addTarget(Target $target): Call;
}
