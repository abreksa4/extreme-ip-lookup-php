<?php declare(strict_types=1);


namespace Test\Unit;


use AndrewBreksa\ExtremeIPLookup\IPResult;
use PHPUnit\Framework\TestCase;

/**
 * Class IPResultTest
 * @package Test\Unit
 * @author  Andrew Breksa <andrew@andrewbreksa.com>
 */
class IPResultTest extends TestCase
{

    public function testMagicMethodsGetters(){
        $data = json_decode(ClientTest::SUCCESS_RESPONSE, true);
        $ipResult = new IPResult($data);
        foreach ($data as $key => $value){
            self::assertEquals($value, $ipResult->$key);
        }
    }

    public function testArrayAccessGetters(){
        $data = json_decode(ClientTest::SUCCESS_RESPONSE, true);
        $ipResult = new IPResult($data);
        foreach ($data as $key => $value){
            self::assertArrayHasKey($key, $ipResult);
            self::assertTrue($ipResult->has($key));
            self::assertTrue(isset($ipResult->$key));
            self::assertEquals($value, $ipResult[$key]);
        }
    }

    public function testArrayAccessSetter(){
        $data = json_decode(ClientTest::SUCCESS_RESPONSE, true);
        $ipResult = new IPResult($data);
        $ipResult['foo'] = 'bar';
        self::assertEquals($ipResult->foo, 'bar');
    }

    public function testMagicMethodSetter(){
        $data = json_decode(ClientTest::SUCCESS_RESPONSE, true);
        $ipResult = new IPResult($data);
        $ipResult->foo = 'bar';
        self::assertEquals($ipResult['foo'], 'bar');
    }

    public function testArrayUnset(){
        $data = json_decode(ClientTest::SUCCESS_RESPONSE, true);
        $ipResult = new IPResult($data);
        unset($ipResult['businessName']);
        self::assertArrayNotHasKey('businessName', $ipResult);
    }

    public function testGet(){
        $data = json_decode(ClientTest::SUCCESS_RESPONSE, true);
        $ipResult = new IPResult($data);
        self::assertEquals('Sandhills Publishing Company', $ipResult->get('businessName'));
    }

    public function testGetWithDefault(){
        $data = json_decode(ClientTest::SUCCESS_RESPONSE, true);
        $ipResult = new IPResult($data);
        self::assertEquals('bar', $ipResult->get('foo', 'bar'));
    }

}