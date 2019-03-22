<?php
/**
 * Copyright (c) 2019 Florian Levis.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace Gounlaf\VwsApiClient\Test\Integration;

use Gounlaf\VwsApiClient\Contracts\Response\SimpleResponse;
use Gounlaf\VwsApiClient\Target;
use Gounlaf\VwsApiClient\Test\TestCase;
use Gounlaf\VwsApiClient\VuforiaWebServices;
use GuzzleHttp\Client;
use function GuzzleHttp\Psr7\stream_for;
use function GuzzleHttp\Psr7\uri_for;
use Mcustiel\Phiremock\Client\Phiremock;
use Mcustiel\Phiremock\Client\Utils\A;
use Mcustiel\Phiremock\Client\Utils\Is;
use Mcustiel\Phiremock\Client\Utils\Respond;
use Tebru\Gson\Gson;
use Tebru\Retrofit\Retrofit;
use Tebru\RetrofitConverter\Gson\GsonConverterFactory;
use Tebru\RetrofitHttp\Guzzle6\Guzzle6HttpClient;

final class VuforiaWebServicesTest extends TestCase
{
    /**
     * @var Phiremock
     */
    private $phiremockClient;

    /**
     * @var VuforiaWebServices
     */
    private $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->phiremockClient = new Phiremock(getenv('PHIREMOCK_HOST'), getenv('PHIREMOCK_PORT'));

        $baseUrl = uri_for('')
            ->withHost(getenv('PHIREMOCK_HOST'))
            ->withPort(getenv('PHIREMOCK_PORT'));

        $retrofit = Retrofit::builder()
            ->setBaseUrl((string) $baseUrl)
            ->setHttpClient(new Guzzle6HttpClient(new Client()))
            ->addConverterFactory(new GsonConverterFactory(Gson::builder()->build()))
            ->build();

        $this->client = $retrofit->create(VuforiaWebServices::class);
    }

    protected function tearDown(): void
    {
        $this->phiremockClient->clearExpectations();
        parent::tearDown();
    }

    public function testAddTarget()
    {
        $target = new Target(
            'test',
            3.14,
            stream_for(base64_encode('image')),
            true,
            stream_for(base64_encode('application_metadata'))
        );

        $targetAsJson = <<<'JSON'
{
  "name": "test",
  "width": 3.14,
  "image": "aW1hZ2U=",
  "active_flag": true,
  "application_metadata": "YXBwbGljYXRpb25fbWV0YWRhdGE="
}
JSON;

        $serverResponseContent = <<<'JSON'
{
  "result_code":"Success",
  "transaction_id":"550e8400e29b41d4a716446655482752"
}
JSON;


        $expectation = Phiremock::on(
            A::postRequest()
                ->andUrl(Is::equalTo('/targets'))
                ->andBody(Is::sameJsonObjectAs($targetAsJson))
        )->then(
            Respond::withStatusCode(200)
                ->andBody($serverResponseContent)
                ->andHeader('Content-Type', 'application/json')
        );

        $this->phiremockClient->createExpectation($expectation);

        $response = $this->client->addTarget($target)->execute();
        $this->assertSame(200, $response->code());
        $body = $response->body();
        $this->assertInstanceOf(SimpleResponse::class, $body);
    }
}
