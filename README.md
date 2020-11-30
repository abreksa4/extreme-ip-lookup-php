eXTReMe IP LOOKUP Client
------------------------

_A simple wrapper for eXTReMe-IP-LOOKUP.com_

# Installation
- Add `https://github.com/abreksa4/extreme-ip-lookup-php.git` to your [composer repositories](https://getcomposer.org/doc/05-repositories.md)
- Run `composer require andrewbreksa/exteme-ip-lookup`

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

`\AndrewBreksa\ExtremeIPLookup\Client::lookup` returns an instance of [`\AndrewBreksa\ExtremeIPLookup\IPResult`](./src/IPResult.php) on 
success, and throws [`\AndrewBreksa\ExtremeIPLookup\ExtremeIPLookupException`](./src/ExtremeIPLookupException.php) on error.
