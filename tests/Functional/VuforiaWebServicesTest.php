<?php
/**
 * Copyright (c) 2019 Florian Levis.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace Gounlaf\VwsApiClient\Test\Functional;

use Carbon\CarbonImmutable;
use Endroid\QrCode\QrCode;
use Gounlaf\VwsApiClient\Contracts\Response\SimpleResponse;
use Gounlaf\VwsApiClient\Middlewares\VWSSignature;
use Gounlaf\VwsApiClient\SignatureBuilder;
use Gounlaf\VwsApiClient\Target;
use Gounlaf\VwsApiClient\Test\TestCase;
use Gounlaf\VwsApiClient\VuforiaWebServices;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Tebru\Gson\Gson;
use Tebru\Retrofit\Retrofit;
use Tebru\RetrofitConverter\Gson\GsonConverterFactory;
use Tebru\RetrofitHttp\Guzzle6\Guzzle6HttpClient;
use function GuzzleHttp\Psr7\stream_for;
use function GuzzleHttp\Psr7\uri_for;

final class VuforiaWebServicesTest extends TestCase
{
    /**
     * @var VuforiaWebServices
     */
    private $client;

    protected function setUp(): void
    {
        parent::setUp();

        $accessKey = getenv('VUFORIA_ACCESS_KEY');
        $secretKey = getenv('VUFORIA_SECRET_KEY');

        if (false === $accessKey || false === $secretKey || $accessKey === 'test' || $secretKey === 'test') {
            $this->markTestSkipped('VUFORIA_ACCESS_KEY and/or VUFORIA_SECRET_KEY are not defined with real values');
            return;
        }

        $baseUrl = uri_for(VuforiaWebServices::DEFAULT_BASE_URL);

        $signatureMiddleware = new VWSSignature(new SignatureBuilder(), $accessKey, $secretKey);

        $guzzleStack = HandlerStack::create();
        $guzzleStack->push(Middleware::mapRequest($signatureMiddleware));

        $retrofit = Retrofit::builder()
            ->setBaseUrl((string)$baseUrl)
            ->setHttpClient(new Guzzle6HttpClient(new Client(['handler' => $guzzleStack])))
            ->addConverterFactory(new GsonConverterFactory(Gson::builder()->build()))
            ->build();

        $this->client = $retrofit->create(VuforiaWebServices::class);
    }

    public function testAddTarget()
    {
        $content = json_encode([
            'url' => 'https://gitlab.com/Gounlaf/vuforia-vws-api-client',
            'method' => __METHOD__,
        ]);

        $target = new Target(
            'test-add-target-' . CarbonImmutable::now()->format(('Ymd_His')),
            3.14,
            stream_for(base64_encode($this->generateImageAsString($content))),
            true,
            stream_for(base64_encode($content))
        );

        $response = $this->client->addTarget($target)->execute();

        $this->assertSame(201, $response->code());
        $body = $response->body();
        $this->assertInstanceOf(SimpleResponse::class, $body);
        $this->assertSame('TargetCreated', $body->getResultCode());
    }

    private function generateImageAsString(string $content): string
    {
        $qrCode = new QrCode($content);
        $qrCode->setWriterByName('png');

        // Turn off alpha ("Only 8 bit gray scale or 24 bit RGB of file type JPG or PNG are allowed")
        $png = imagecreatefromstring($qrCode->writeString());
        imagealphablending($png, false);
        imagesavealpha($png, false);
        ob_start();
        imagepng($png);

        return ob_get_clean();
    }
}
