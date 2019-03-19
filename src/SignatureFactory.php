<?php
/**
 * Copyright (c) 2019 Florian Levis.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace Gounlaf\VfsApiClient;

use Carbon\Carbon;
use Exception;
use GuzzleHttp\Psr7\StreamWrapper;
use InvalidArgumentException;
use Psr\Http\Message\RequestInterface;

/**
 * Class SignatureBuilder
 * @package Gounlaf\VfsApiClient
 *
 * @see https://library.vuforia.com/content/vuforia-library/en/articles/Training/Using-the-VWS-API.html Making API calls
 */
final class SignatureFactory
{
    const EMPTY_STR_MD5 = 'd41d8cd98f00b204e9800998ecf8427e';

    /**
     * Signature = Base64(HMAC-SHA1(server_secret_key, StringToSign ) ) ;
     * StringToSign = HTTP-Verb + "\n" + Content-MD5 + "\n" + Content-Type + "\n" + Date + "\n" + Request-Path;
     * Where:
     *   - HTTP-Verb is the HTTP method used for the action, for example, GET, POST, and so forth.
     *   - Content-MD5 is the hexadecimal MD5 hash of the whole request body (from the first boundary to the last one,
     *     including the boundary itself).
     *     For request types without request body, include the MD5 hash of an empty string
     *     which is “d41d8cd98f00b204e9800998ecf8427e”.
     *   - Content-Type is the content-type of the request body (like multipart/form-data).
     *     Use an empty string for request types without a request body.
     *   - Date is the current date per RFC 2616, section 3.3.1, rfc1123-date format,
     *     for example, Sun, 22 Apr 2012 08:49:37 GMT.
     *   - NOTE: The date and time always refer to GMT
     *
     * @param RequestInterface $request
     * @param string $secretKey
     * @return string
     * @throws Exception
     */
    public static function createSignatureForRequest(RequestInterface $request, string $secretKey)
    {
        $httpVerb = strtoupper($request->getMethod());

        switch ($httpVerb) {
            case 'POST':
            case 'PUT':
            case 'PATCH':
                $contentType = $request->getHeaderLine('Content-Type');
                if ($contentType !== 'application/json') {
                    throw new InvalidArgumentException('Expected Content-Type to be application/json');
                }

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

        if ($request->hasHeader('Date')) {
            $date = Carbon::createFromFormat(DATE_RFC7231, $request->getHeaderLine('Date'));
        } else {
            $date = Carbon::now('UTC');
        }

        $stringToSign =
            $httpVerb . PHP_EOL .
            $contentMd5 . PHP_EOL .
            $contentType . PHP_EOL .
            $date->toRfc7231String() . PHP_EOL .
            $request->getUri()->getPath();

        return base64_encode(hash_hmac('sha1', $stringToSign, $secretKey, true));
    }
}
