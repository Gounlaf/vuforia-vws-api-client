<?php
/**
 * Copyright (c) 2019 Florian Levis.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace Gounlaf\VwsApiClient\Test\Unit\Middlewares;

use Carbon\Carbon;
use Gounlaf\VwsApiClient\Contracts\SignatureBuilder;
use Gounlaf\VwsApiClient\Middlewares\VWSSignature;
use Gounlaf\VwsApiClient\Test\TestCase;
use Mockery;
use Zend\Diactoros\RequestFactory;

final class VWSSignatureTest extends TestCase
{
    public function testProcess()
    {
        /** @var SignatureBuilder|Mockery\MockInterface $signatureBuilder */
        $signatureBuilder = Mockery::mock(SignatureBuilder::class);
        $middleware = new VWSSignature($signatureBuilder, 'access_key', 'secret_key');

        $request = (new RequestFactory())
            ->createRequest('POST', '/whatever')
            ->withHeader('Date', Carbon::now()->toRfc7231String());

        $signatureBuilder->shouldReceive('createSignatureForRequest')
            ->andReturn('signature');

        $request = $middleware->process($request);

        $this->assertTrue($request->hasHeader('Authorization'));
        $this->assertSame('VWS access_key:signature', $request->getHeaderLine('Authorization'));
    }

    public function testProcessWithoutDate()
    {
        $now = Carbon::now();
        Carbon::setTestNow($now);

        /** @var SignatureBuilder|Mockery\MockInterface $signatureBuilder */
        $signatureBuilder = Mockery::mock(SignatureBuilder::class);
        $middleware = new VWSSignature($signatureBuilder, 'access_key', 'secret_key');

        $request = (new RequestFactory())
            ->createRequest('POST', '/whatever');

        $signatureBuilder->shouldReceive('createSignatureForRequest')
            ->andReturn('signature');

        $request = $middleware->process($request);

        $this->assertTrue($request->hasHeader('Authorization'));
        $this->assertSame('VWS access_key:signature', $request->getHeaderLine('Authorization'));
    }

    public function testProcessAsCallable()
    {
        /** @var SignatureBuilder|Mockery\MockInterface $signatureBuilder */
        $signatureBuilder = Mockery::mock(SignatureBuilder::class);
        $middleware = new VWSSignature($signatureBuilder, 'access_key', 'secret_key');

        $request = (new RequestFactory())
            ->createRequest('POST', '/whatever')
            ->withHeader('Date', Carbon::now()->toRfc7231String());

        $signatureBuilder->shouldReceive('createSignatureForRequest')
            ->with($request, 'secret_key')
            ->andReturn('signature');

        $request = $middleware($request);

        $this->assertTrue($request->hasHeader('Authorization'));
        $this->assertSame('VWS access_key:signature', $request->getHeaderLine('Authorization'));
    }
}
