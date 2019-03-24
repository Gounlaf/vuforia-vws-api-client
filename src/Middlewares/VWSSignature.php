<?php
/**
 * Copyright (c) 2019 Florian Levis.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace Gounlaf\VwsApiClient\Middlewares;

use Carbon\Carbon;
use Gounlaf\VwsApiClient\Contracts\SignatureBuilder;
use Psr\Http\Message\RequestInterface;

final class VWSSignature
{
    /**
     * @var SignatureBuilder
     */
    private $signatureBuilder;

    /**
     * @var string
     */
    private $accessKey;

    /**
     * @var string
     */
    private $secretKey;

    public function __construct(SignatureBuilder $signatureBuilder, string $accessKey, string $secretKey)
    {
        $this->signatureBuilder = $signatureBuilder;
        $this->accessKey = $accessKey;
        $this->secretKey = $secretKey;
    }

    public function __invoke(RequestInterface $request)
    {
        return $this->process($request);
    }

    public function process(RequestInterface $request): RequestInterface
    {
        if (!$request->hasHeader('Date')) {
            $request = $request->withHeader('Date', Carbon::now()->toRfc7231String());
        }

        return $request->withAddedHeader('Authorization', sprintf(
            'VWS %s:%s',
            $this->accessKey,
            $this->signatureBuilder->createSignatureForRequest($request, $this->secretKey)
        ));
    }
}
