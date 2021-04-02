<?php

declare(strict_types=1);

namespace AndrewBreksa\ExtremeIPLookup;

use Http\Client\HttpClient;
use Http\Message\MessageFactory;
use Suin\Json\DecodingException;
use function Suin\Json\json_decode;

/**
 * Class Client
 * @package AndrewBreksa\ExtremeIPLookup
 * @author  Andrew Breksa <andrew@andrewbreksa.com>
 */
class Client implements ClientInterface
{
    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @var MessageFactory
     */
    protected $httpMessageFactory;

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * Client constructor.
     * @param HttpClient     $httpClient
     * @param MessageFactory $httpMessageFactory
     * @param string         $apiKey
     */
    public function __construct(HttpClient $httpClient, MessageFactory $httpMessageFactory, string $apiKey)
    {
        $this->httpClient         = $httpClient;
        $this->httpMessageFactory = $httpMessageFactory;
        $this->apiKey             = $apiKey;
    }

    /**
     * @param string $ipAddress
     * @return IPResult
     * @throws ExtremeIPLookupException
     * @throws DecodingException
     */
    public function lookup(string $ipAddress): IPResult
    {
        $request = $this->httpMessageFactory->createRequest(
            'GET',
            'https://extreme-ip-lookup.com/json/' . $ipAddress . '?key=' . $this->apiKey
        );

        $response = $this->httpClient->sendRequest($request);

        if ($response->getStatusCode() !== 200) {
            throw new ExtremeIPLookupException(
                'non-200 status code from eXTReMe-IP-LOOKUP',
                $request,
                $response
            );
        }

        $body = json_decode($response->getBody()->getContents(), true);

        if ($body['status'] === 'fail') {
            throw new ExtremeIPLookupException(
                $body['message'],
                $request,
                $response
            );
        }

        return new IPResult($body);
    }
}
