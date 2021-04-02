<?php

declare(strict_types=1);

namespace AndrewBreksa\ExtremeIPLookup;

use Suin\Json\DecodingException;

/**
 * Interface ClientInterface
 * @package AndrewBreksa\ExtremeIPLookup
 * @author  Andrew Breksa <andrew@andrewbreksa.com>
 */
interface ClientInterface
{
    /**
     * @param string $ipAddress
     * @return IPResult
     * @throws ExtremeIPLookupException
     * @throws DecodingException
     */
    public function lookup(string $ipAddress): IPResult;
}
