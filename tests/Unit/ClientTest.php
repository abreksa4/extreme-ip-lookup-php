<?php

declare(strict_types=1);

namespace Test\Unit;

use AndrewBreksa\ExtremeIPLookup\ExtremeIPLookupException;
use AndrewBreksa\ExtremeIPLookup\IPResult;
use Http\Client\HttpClient;
use Http\Message\MessageFactory;
use Mockery;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Class ClientTest
 * @package Test\Unit
 * @author  Andrew Breksa <andrew@andrewbreksa.com>
 */
class ClientTest extends TestCase
{
    public const SUCCESS_RESPONSE = '{"businessName":"Sandhills Publishing Company","businessWebsite":"www.sandhills.com","city":"Lincoln","continent":"North America","country":"United States","countryCode":"US","ipName":"proxy.sandhills.com","ipType":"Business","isp":"Sandhills Publishing","lat":"40.8","lon":"-96.66696","org":"Sandhills Publishing Company","query":"63.70.164.200","region":"Nebraska","status":"success","timezone":"America/Chicago","utcOffset":"-05:00"}';

    public const FAIL_RESPONSE = '{"status":"fail","message":"this is a test problem"}';

    public function testSuccess()
    {
        $mock    = Mockery::mock(HttpClient::class);
        $factory = Mockery::mock(MessageFactory::class);
        $apiKey  = 'test-api-key';
        $ip      = '63.70.164.200';

        $client = new \AndrewBreksa\ExtremeIPLookup\Client(
            $mock,
            $factory,
            $apiKey
        );

        $response = Mockery::mock(ResponseInterface::class);
        $response->expects('getStatusCode')
                 ->andReturns(200);
        $stream = Mockery::mock(StreamInterface::class);
        $stream->expects('getContents')
               ->andReturns(self::SUCCESS_RESPONSE);
        $response->expects('getBody')
                 ->andReturns($stream);

        $request = Mockery::mock(RequestInterface::class);

        $factory->expects('createRequest')
                ->with(
                    'GET',
                    'https://extreme-ip-lookup.com/json/' . $ip . '?key=' . $apiKey
                )
                ->andReturns($request);

        $mock->expects('sendRequest')
             ->with($request)
             ->andReturns($response);

        $ipResult = $client->lookup($ip);

        self::assertInstanceOf(IPResult::class, $ipResult);
        self::assertEquals(json_decode(self::SUCCESS_RESPONSE, true), $ipResult->jsonSerialize());
    }

    public function testNon200ResponseCode()
    {
        $mock    = Mockery::mock(HttpClient::class);
        $factory = Mockery::mock(MessageFactory::class);
        $apiKey  = 'test-api-key';
        $ip      = '63.70.164.200';

        $client = new \AndrewBreksa\ExtremeIPLookup\Client(
            $mock,
            $factory,
            $apiKey
        );

        $response = Mockery::mock(ResponseInterface::class);
        $response->expects('getStatusCode')
                 ->andReturns(400);

        $request = Mockery::mock(RequestInterface::class);

        $factory->expects('createRequest')
                ->with(
                    'GET',
                    'https://extreme-ip-lookup.com/json/' . $ip . '?key=' . $apiKey
                )
                ->andReturns($request);

        $mock->expects('sendRequest')
             ->with($request)
             ->andReturns($response);

        $this->expectException(ExtremeIPLookupException::class);

        $client->lookup($ip);
    }

    public function testFail()
    {
        $mock    = Mockery::mock(HttpClient::class);
        $factory = Mockery::mock(MessageFactory::class);
        $apiKey  = 'test-api-key';
        $ip      = '63.70.164.200';

        $client = new \AndrewBreksa\ExtremeIPLookup\Client(
            $mock,
            $factory,
            $apiKey
        );

        $response = Mockery::mock(ResponseInterface::class);
        $response->expects('getStatusCode')
                 ->andReturns(200);
        $stream = Mockery::mock(StreamInterface::class);
        $stream->expects('getContents')
               ->andReturns(self::FAIL_RESPONSE);
        $response->expects('getBody')
                 ->andReturns($stream);

        $request = Mockery::mock(RequestInterface::class);

        $factory->expects('createRequest')
                ->with(
                    'GET',
                    'https://extreme-ip-lookup.com/json/' . $ip . '?key=' . $apiKey
                )
                ->andReturns($request);

        $mock->expects('sendRequest')
             ->with($request)
             ->andReturns($response);

        $this->expectException(ExtremeIPLookupException::class);

        $client->lookup($ip);
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
