<?php

declare(strict_types=1);

namespace AndrewBreksa\ExtremeIPLookup;

use Exception;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ExtremeIPLookupException
 * @package AndrewBreksa\ExtremeIPLookup
 * @author  Andrew Breksa <andrew@andrewbreksa.com>
 */
class ExtremeIPLookupException extends Exception
{
    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * ExtremeIPLookupException constructor.
     * @param string            $message
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     */
    public function __construct(string $message, RequestInterface $request, ResponseInterface $response)
    {
        parent::__construct($message);
        $this->request  = $request;
        $this->response = $response;
    }

    /**
     * @return RequestInterface
     */
    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}
