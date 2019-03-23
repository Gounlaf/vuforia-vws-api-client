<?php
/**
 * Copyright (c) 2019 Florian Levis.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace Gounlaf\VwsApiClient\Contracts;

use Psr\Http\Message\RequestInterface;

interface SignatureBuilder
{
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
     */
    public function createSignatureForRequest(RequestInterface $request, string $secretKey): string;
}
