<?php declare(strict_types=1);


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

    const SUCCESS_RESPONSE = '{"businessName":"Sandhills Publishing Company","businessWebsite":"www.sandhills.com","city":"Lincoln","continent":"North America","country":"United States","countryCode":"US","ipName":"proxy.sandhills.com","ipType":"Business","isp":"Sandhills Publishing","lat":"40.8","lon":"-96.66696","org":"Sandhills Publishing Company","query":"63.70.164.200","region":"Nebraska","status":"success","timezone":"America/Chicago","utcOffset":"-05:00"}';

    const FAIL_RESPONSE = '{"status":"fail","message":"this is a test problem"}';

    public function testSuccess()
    {
        $mock = Mockery::mock(HttpClient::class);
        $factory = Mockery::mock(MessageFactory::class);
        $apiKey = 'test-api-key';
        $ip = '63.70.164.200';

        $client = new \AndrewBreksa\ExtremeIPLookup\Client(
            $mock,
            $factory,
            $apiKey
        );

        $response = Mockery::mock(ResponseInterface::class);
        $response->shouldReceive('getStatusCode')
            ->andReturn(200)
            ->once();
        $stream = Mockery::mock(StreamInterface::class);
        $stream->shouldReceive('getContents')
            ->andReturn(self::SUCCESS_RESPONSE)
            ->once();
        $response->shouldReceive('getBody')
            ->andReturn($stream)
            ->once();

        $request = Mockery::mock(RequestInterface::class);

        $factory->shouldReceive('createRequest')
            ->with(
                'GET',
                'https://extreme-ip-lookup.com/json/' . $ip . '?key=' . $apiKey
            )
            ->andReturn($request)
            ->once();

        $mock->shouldReceive('sendRequest')
            ->with($request)
            ->andReturn($response)
            ->once();

        $ipResult = $client->lookup($ip);

        self::assertInstanceOf(IPResult::class, $ipResult);
        self::assertEquals(json_decode(self::SUCCESS_RESPONSE, true), $ipResult->jsonSerialize());
    }

    public function testNon200ResponseCode()
    {
        $mock = Mockery::mock(HttpClient::class);
        $factory = Mockery::mock(MessageFactory::class);
        $apiKey = 'test-api-key';
        $ip = '63.70.164.200';

        $client = new \AndrewBreksa\ExtremeIPLookup\Client(
            $mock,
            $factory,
            $apiKey
        );

        $response = Mockery::mock(ResponseInterface::class);
        $response->shouldReceive('getStatusCode')
            ->andReturn(400)
            ->once();

        $request = Mockery::mock(RequestInterface::class);

        $factory->shouldReceive('createRequest')
            ->with(
                'GET',
                'https://extreme-ip-lookup.com/json/' . $ip . '?key=' . $apiKey
            )
            ->andReturn($request)
            ->once();

        $mock->shouldReceive('sendRequest')
            ->with($request)
            ->andReturn($response)
            ->once();

        $this->expectException(ExtremeIPLookupException::class);

        $client->lookup($ip);

    }

    public function testFail()
    {
        $mock = Mockery::mock(HttpClient::class);
        $factory = Mockery::mock(MessageFactory::class);
        $apiKey = 'test-api-key';
        $ip = '63.70.164.200';

        $client = new \AndrewBreksa\ExtremeIPLookup\Client(
            $mock,
            $factory,
            $apiKey
        );

        $response = Mockery::mock(ResponseInterface::class);
        $response->shouldReceive('getStatusCode')
            ->andReturn(200)
            ->once();
        $stream = Mockery::mock(StreamInterface::class);
        $stream->shouldReceive('getContents')
            ->andReturn(self::FAIL_RESPONSE)
            ->once();
        $response->shouldReceive('getBody')
            ->andReturn($stream)
            ->once();

        $request = Mockery::mock(RequestInterface::class);

        $factory->shouldReceive('createRequest')
            ->with(
                'GET',
                'https://extreme-ip-lookup.com/json/' . $ip . '?key=' . $apiKey
            )
            ->andReturn($request)
            ->once();

        $mock->shouldReceive('sendRequest')
            ->with($request)
            ->andReturn($response)
            ->once();

        $this->expectException(ExtremeIPLookupException::class);

        $client->lookup($ip);

    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

}