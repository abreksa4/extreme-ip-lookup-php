<?php

declare(strict_types=1);

namespace Test\Unit;

use AndrewBreksa\ExtremeIPLookup\ExtremeIPLookupException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ExtremeIPLookupExceptionTest
 * @package Test\Unit
 * @author  Andrew Breksa <andrew@andrewbreksa.com>
 */
class ExtremeIPLookupExceptionTest extends TestCase
{
    public function testGetterSetter()
    {
        $request   = \Mockery::mock(RequestInterface::class);
        $response  = \Mockery::mock(ResponseInterface::class);
        $exception = new ExtremeIPLookupException(
            'Test Message',
            $request,
            $response
        );

        self::assertEquals($request, $exception->getRequest());
        self::assertEquals($response, $exception->getResponse());
    }

    public function tearDown(): void
    {
        \Mockery::close();
        parent::tearDown();
    }
}
