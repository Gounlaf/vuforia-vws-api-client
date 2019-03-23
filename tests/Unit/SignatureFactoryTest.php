<?php
/**
 * Copyright (c) 2019 Florian Levis.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace Gounlaf\VwsApiClient\Test\Unit;

use Carbon\Carbon;
use Gounlaf\VwsApiClient\SignatureFactory;
use Gounlaf\VwsApiClient\Test\TestCase;
use InvalidArgumentException;
use Zend\Diactoros\RequestFactory;
use function GuzzleHttp\Psr7\stream_for;

final class SignatureFactoryTest extends TestCase
{
    /**
     * @var Carbon
     */
    private static $date;

    /**
     * @var string
     */
    private static $body;

    /**
     * @var string
     */
    private static $key;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        static::$date = Carbon::create(2018, 3, 18, 21, 29, 00);
        static::$body = json_encode([
            'name' => 'tarmac',
            'width' => 32.0,
            // Yup, this is not an image in base64
            'image' => '0912ba39x...',
            'active_flag' => true,
            'application_metadata' => '496fbb6532b3863460a984de1d980bed5ebcd507',
        ]);
        static::$key = 'Don\'t Panic';
    }

    public function testSignatureFactoryForPost()
    {
        $request = (new RequestFactory())->createRequest('POST', '/post')
            ->withBody(stream_for(static::$body))
            ->withHeader('Date', static::$date->toRfc1123String())
            ->withHeader('Content-Type', 'application/json');

        $this->assertSame(
            'cHSw7u438JHbj2ZytL4fdK8iEpw=',
            SignatureFactory::createSignatureForRequest($request, static::$key)
        );
    }

    public function testSignatureFactoryForPostWithoutDate()
    {
        $this->expectException(InvalidArgumentException::class);

        $request = (new RequestFactory())->createRequest('POST', '/post')
            ->withBody(stream_for(static::$body))
            ->withHeader('Content-Type', 'application/json');

        SignatureFactory::createSignatureForRequest($request, static::$key);
    }

    public function testSignatureFactoryForPostJsonRequired()
    {
        $this->expectException(InvalidArgumentException::class);

        $request = (new RequestFactory())->createRequest('POST', '/post')
            ->withBody(stream_for(static::$body))
            ->withHeader('Date', static::$date->toRfc1123String());

        SignatureFactory::createSignatureForRequest($request, static::$key);
    }

    public function testSignatureFactoryForPut()
    {
        $request = (new RequestFactory())->createRequest('PUT', '/put')
            ->withBody(stream_for(static::$body))
            ->withHeader('Date', static::$date->toRfc1123String())
            ->withHeader('Content-Type', 'application/json');

        $this->assertSame(
            '4f/ucWNyopuodxTcfXBPw2boADA=',
            SignatureFactory::createSignatureForRequest($request, static::$key)
        );
    }

    public function testSignatureFactoryForPutJsonRequired()
    {
        $this->expectException(InvalidArgumentException::class);

        $request = (new RequestFactory())->createRequest('PUT', '/put')
            ->withBody(stream_for(static::$body))
            ->withHeader('Date', static::$date->toRfc1123String());

        SignatureFactory::createSignatureForRequest($request, static::$key);
    }

    public function testSignatureFactoryForPatch()
    {
        $request = (new RequestFactory())->createRequest('PATCH', '/patch')
            ->withBody(stream_for(static::$body))
            ->withHeader('Date', static::$date->toRfc1123String())
            ->withHeader('Content-Type', 'application/json');

        $this->assertSame(
            'J+yNhypBDCeXCOrVW8jPcB0JojU=',
            SignatureFactory::createSignatureForRequest($request, static::$key)
        );
    }

    public function testSignatureFactoryForPatchJsonRequired()
    {
        $this->expectException(InvalidArgumentException::class);

        $request = (new RequestFactory())->createRequest('PATCH', '/patch')
            ->withBody(stream_for(static::$body))
            ->withHeader('Date', static::$date->toRfc1123String());

        SignatureFactory::createSignatureForRequest($request, static::$key);
    }

    public function testSignatureFactoryForDelete()
    {
        $request = (new RequestFactory())->createRequest('DELETE', '/delete')
            ->withHeader('Date', static::$date->toRfc1123String());

        $this->assertSame(
            'jvc+Q82/i2MMt54T4zGRS6Nqaco=',
            SignatureFactory::createSignatureForRequest($request, static::$key)
        );
    }

    public function testSignatureFactoryForDeleteWithBody()
    {
        // body & content-type are not used (but request can still be build with them)

        $request = (new RequestFactory())->createRequest('DELETE', '/delete')
            ->withBody(stream_for(static::$body))
            ->withHeader('Date', static::$date->toRfc1123String())
            ->withHeader('Content-Type', 'application/json');

        $this->assertSame(
            'jvc+Q82/i2MMt54T4zGRS6Nqaco=',
            SignatureFactory::createSignatureForRequest($request, static::$key)
        );
    }

    public function testSignatureFactoryForGet()
    {
        $request = (new RequestFactory())->createRequest('GET', '/get')
            ->withHeader('Date', static::$date->toRfc1123String());

        $this->assertSame(
            'LAM4Z4Kt2aMFDP1rNFMSXnwWoB8=',
            SignatureFactory::createSignatureForRequest($request, static::$key)
        );
    }

    public function testSignatureFactoryForGetWithBody()
    {
        // body & content-type are inconsistent with a get request (but request can still be build with them)

        $request = (new RequestFactory())->createRequest('GET', '/get')
            ->withBody(stream_for(static::$body))
            ->withHeader('Date', static::$date->toRfc1123String())
            ->withHeader('Content-Type', 'application/json');

        $this->assertSame(
            'LAM4Z4Kt2aMFDP1rNFMSXnwWoB8=',
            SignatureFactory::createSignatureForRequest($request, static::$key)
        );
    }
}
