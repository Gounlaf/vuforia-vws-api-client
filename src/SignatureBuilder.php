<?php
/**
 * Copyright (c) 2019 Florian Levis.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace Gounlaf\VwsApiClient;

use Gounlaf\VwsApiClient\Contracts\SignatureBuilder as Contract;
use GuzzleHttp\Psr7\StreamWrapper;
use InvalidArgumentException;
use Psr\Http\Message\RequestInterface;

/**
 * Class SignatureBuilder
 * @package Gounlaf\VwsApiClient
 *
 * @see https://library.vuforia.com/content/vuforia-library/en/articles/Training/Using-the-VWS-API.html Making API calls
 */
final class SignatureBuilder implements Contract
{
    const EMPTY_STR_MD5 = 'd41d8cd98f00b204e9800998ecf8427e';

    /**
     * @inheritDoc
     *
     * @throws InvalidArgumentException
     */
    public function createSignatureForRequest(RequestInterface $request, string $secretKey): string
    {
        Assert::true($request->hasHeader('Date'), 'Date header required');
        $dateHeader = $request->getHeaderLine('Date');
        Assert::dateFormat($dateHeader, DATE_RFC7231);

        $httpVerb = strtoupper($request->getMethod());

        switch ($httpVerb) {
            case 'POST':
            case 'PUT':
            case 'PATCH':
                Assert::true($request->hasHeader('Content-Type'), 'Content-Type header required');
                $contentType = $request->getHeaderLine('Content-Type');
                Assert::oneOf($contentType, ['application/json'], 'Expected Content-Type to be one of: %2$s. Got: %s');

                $body = $request->getBody();
                $body->rewind();

                $ctx = hash_init('md5');
                hash_update_stream($ctx, StreamWrapper::getResource($body));
                $contentMd5 = hash_final($ctx);
                break;

            case 'GET':
            case 'DELETE':
            default:
                $contentMd5 = static::EMPTY_STR_MD5;
                $contentType = '';
                break;
        }

        $stringToSign =
            $httpVerb . PHP_EOL .
            $contentMd5 . PHP_EOL .
            $contentType . PHP_EOL .
            $dateHeader . PHP_EOL .
            $request->getUri()->getPath();

        return base64_encode(hash_hmac('sha1', $stringToSign, $secretKey, true));
    }
}
