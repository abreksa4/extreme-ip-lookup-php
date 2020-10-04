<?php declare(strict_types=1);


namespace Test\Feature;


use AndrewBreksa\ExtremeIPLookup\Client;
use AndrewBreksa\ExtremeIPLookup\ExtremeIPLookupException;
use AndrewBreksa\ExtremeIPLookup\IPResult;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Discovery\StreamFactoryDiscovery;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client as GuzzleClient;
use Http\Adapter\Guzzle7\Client as GuzzleAdapter;

/**
 * Class ClientTest
 * @package Test\Feature
 * @author  Andrew Breksa <andrew@andrewbreksa.com>
 */
class ClientTest extends TestCase
{

    public function testSuccess()
    {

        $client = new Client(
            new GuzzleAdapter(new GuzzleClient()),
            new GuzzleMessageFactory(),
            getenv('EXT_IP_KEY')
        );

        $ip = '63.70.164.200';

        $result = $client->lookup($ip);

        self::assertInstanceOf(IPResult::class, $result);
    }

    public function testInvalidIP()
    {

        $client = new Client(
            new GuzzleAdapter(new GuzzleClient()),
            new GuzzleMessageFactory(),
            getenv('EXT_IP_KEY')
        );

        $ip = '63.70.164.';

        $this->expectException(ExtremeIPLookupException::class);

        $client->lookup($ip);
    }

}