<?php
/**
 * Copyright (c) 2019 Florian Levis.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace Gounlaf\VwsApiClient;

use Gounlaf\VwsApiClient\Contracts\Call\AddTargetCall;
use Gounlaf\VwsApiClient\Contracts\Call\GetTargetCall;
use Tebru\Retrofit\Annotation\Body;
use Tebru\Retrofit\Annotation\GET;
use Tebru\Retrofit\Annotation\PATCH;
use Tebru\Retrofit\Annotation\Path;
use Tebru\Retrofit\Annotation\POST;
use Tebru\Retrofit\Annotation\ResponseBody;
use Tebru\Retrofit\Call;

interface VuforiaWebServices
{
    const DEFAULT_BASE_URL = 'https://vws.vuforia.com';

    /**
     * @POST("/targets")
     * @Body("target")
     * @ResponseBody("Gounlaf\VwsApiClient\Impl\Response\Body\AddTargetResponseBody")
     *
     * @param Target $target
     *
     * @return Call|AddTargetCall
     */
    public function addTarget(Target $target): Call;

    /**
     * @GET("/targets/{target_id}")
     * @Path("target_id", var="targetId")
     * @ResponseBody("Gounlaf\VwsApiClient\Impl\Response\Body\GetTargetResponseBody")
     *
     * @param string $targetId
     *
     * @return Call|GetTargetCall
     */
    public function getTarget(string $targetId): Call;
}
