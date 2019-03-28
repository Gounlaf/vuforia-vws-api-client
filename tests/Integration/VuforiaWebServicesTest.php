<?php
/**
 * Copyright (c) 2019 Florian Levis.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

declare(strict_types=1);

namespace Gounlaf\VwsApiClient\Test\Integration;

use Gounlaf\VwsApiClient\Contracts\Model\AddTargetResponseBody;
use Gounlaf\VwsApiClient\Contracts\Model\GetTargetResponseBody;
use Gounlaf\VwsApiClient\Contracts\Model\ResultCode;
use Gounlaf\VwsApiClient\Contracts\Model\TargetRecord;
use Gounlaf\VwsApiClient\Target;
use Gounlaf\VwsApiClient\Test\TestCase;
use Gounlaf\VwsApiClient\VuforiaWebServices;
use GuzzleHttp\Client;
use Mcustiel\Phiremock\Client\Phiremock;
use Mcustiel\Phiremock\Client\Utils\A;
use Mcustiel\Phiremock\Client\Utils\Is;
use Mcustiel\Phiremock\Client\Utils\Respond;
use Tebru\Gson\Gson;
use Tebru\Retrofit\Retrofit;
use Tebru\RetrofitConverter\Gson\GsonConverterFactory;
use Tebru\RetrofitHttp\Guzzle6\Guzzle6HttpClient;
use function GuzzleHttp\Psr7\stream_for;
use function GuzzleHttp\Psr7\uri_for;

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
            ->setBaseUrl((string)$baseUrl)
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
  "transaction_id":"550e8400e29b41d4a716446655482752",
  "target_id": "550e8400e29b41d34716446655834450"
}
JSON;


        $expectation = Phiremock::on(
            A::postRequest()
                ->andUrl(Is::equalTo('/targets'))
                ->andBody(Is::sameJsonObjectAs($targetAsJson))
        )->then(
            Respond::withStatusCode(201)
                ->andBody($serverResponseContent)
                ->andHeader('Content-Type', 'application/json')
        );

        $this->phiremockClient->createExpectation($expectation);

        $response = $this->client->addTarget($target)->execute();
        $this->assertSame(201, $response->code());
        $body = $response->body();
        $this->assertInstanceOf(AddTargetResponseBody::class, $body);
        $this->assertSame(ResultCode::SUCCESS, $body->getResultCode());
        $this->assertSame('550e8400e29b41d4a716446655482752', $body->getTransactionId());
        $this->assertSame('550e8400e29b41d34716446655834450', $body->getTargetId());
    }

    public function testGetTarget()
    {
        $serverResponseContent = <<<'JSON'
{
  "result_code": "Success",
  "transaction_id": "e29b41550e8400d4a716446655440000",
  "target_record": {
    "target_id": "550b41d4a7164466554e8400e2949364",
    "active_flag": true,
    "name": "tarmac",
    "width": 100.0,
    "tracking_rating": 4,
    "reco_rating": ""
  },
  "status": "Success"
}
JSON;

        $expectation = Phiremock::on(
            A::getRequest()
                ->andUrl(Is::equalTo('/targets/550b41d4a7164466554e8400e2949364'))
        )->then(
            Respond::withStatusCode(200)
                ->andBody($serverResponseContent)
                ->andHeader('Content-Type', 'application/json')
        );

        $this->phiremockClient->createExpectation($expectation);

        $response = $this->client->getTarget('550b41d4a7164466554e8400e2949364')->execute();
        $this->assertSame(200, $response->code());
        $body = $response->body();
        $this->assertInstanceOf(GetTargetResponseBody::class, $body);
        $this->assertSame(ResultCode::SUCCESS, $body->getResultCode());
        $this->assertSame('e29b41550e8400d4a716446655440000', $body->getTransactionId());
        $this->assertSame('Success', $body->getStatus());
        $targetRecord = $body->getTargetRecord();
        $this->assertInstanceOf(TargetRecord::class, $targetRecord);
        $this->assertSame('550b41d4a7164466554e8400e2949364', $targetRecord->getTargetId());
        $this->assertSame(true, $targetRecord->getActiveFlag());
        $this->assertSame('tarmac', $targetRecord->getName());
        $this->assertSame(100.0, $targetRecord->getWidth());
        $this->assertSame(4, $targetRecord->getTrackingRating());
        $this->assertSame('', $targetRecord->getRecoRating());
    }
}
