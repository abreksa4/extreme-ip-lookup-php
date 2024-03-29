eXTReMe IP LOOKUP Client
------------------------
[![codecov](https://codecov.io/gh/abreksa4/extreme-ip-lookup-php/branch/master/graph/badge.svg?token=3G90R1YOH3)](https://codecov.io/gh/abreksa4/extreme-ip-lookup-php)
[![workflow](https://github.com/abreksa4/extreme-ip-lookup-php/actions/workflows/ci.yml/badge.svg?branch=main)](https://github.com/abreksa4/extreme-ip-lookup-php)
[![GitHub issues](https://img.shields.io/github/issues/abreksa4/extreme-ip-lookup-php)](https://github.com/abreksa4/extreme-ip-lookup-php/issues)
[![GitHub stars](https://img.shields.io/github/stars/abreksa4/extreme-ip-lookup-php)](https://github.com/abreksa4/extreme-ip-lookup-php/stargazers)
[![Latest Stable Version](https://poser.pugx.org/andrewbreksa/extreme-ip-lookup/v)](//packagist.org/packages/andrewbreksa/extreme-ip-lookup) 
[![Total Downloads](https://poser.pugx.org/andrewbreksa/extreme-ip-lookup/downloads)](//packagist.org/packages/andrewbreksa/extreme-ip-lookup) 
[![Latest Unstable Version](https://poser.pugx.org/andrewbreksa/extreme-ip-lookup/v/unstable)](//packagist.org/packages/andrewbreksa/extreme-ip-lookup) 
[![License](https://poser.pugx.org/andrewbreksa/extreme-ip-lookup/license)](//packagist.org/packages/andrewbreksa/extreme-ip-lookup)

_A simple wrapper for eXTReMe-IP-LOOKUP.com_

# Installation

`composer require andrewbreksa/extreme-ip-lookup`

# Usage

```php
use AndrewBreksa\ExtremeIPLookup\Client;
use GuzzleHttp\Client as GuzzleClient;
use Http\Adapter\Guzzle7\Client as GuzzleAdapter;
use Http\Message\MessageFactory\GuzzleMessageFactory;

$client = new Client(
    new GuzzleAdapter(new GuzzleClient()),
    new GuzzleMessageFactory(),
    getenv('EXT_IP_KEY')
);

$ip = '63.70.164.200';

$result = $client->lookup($ip);
echo $result->isp . PHP_EOL;
```

`\AndrewBreksa\ExtremeIPLookup\Client::lookup` returns an instance
of [`\AndrewBreksa\ExtremeIPLookup\IPResult`](./src/IPResult.php) on success, and
throws [`\AndrewBreksa\ExtremeIPLookup\ExtremeIPLookupException`](./src/ExtremeIPLookupException.php) on error.
