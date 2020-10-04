<?php declare(strict_types=1);


namespace AndrewBreksa\ExtremeIPLookup;


use ArrayAccess;
use JsonSerializable;

/**
 * Class IPResult
 * @package AndrewBreksa\ExtremeIPLookup
 * @author  Andrew Breksa <andrew@andrewbreksa.com>
 * @property string $businessName
 * @property string $businessWebsite
 * @property string $city
 * @property string $continent
 * @property string $country
 * @property string $countryCode
 * @property string $ipName
 * @property string $ipType
 * @property string $isp
 * @property string $lat
 * @property string $lon
 * @property string $org
 * @property string $region
 * @property string $timezone
 * @property string $utcOffset
 */
class IPResult implements JsonSerializable, ArrayAccess
{

    /**
     * @var array
     */
    protected $data = [];

    /**
     * IPResult constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param string $key
     * @param null   $default
     * @return mixed|null
     */
    public function get(string $key, $default = null)
    {
        if (!$this->has($key)) {
            return $default;
        }

        return $this->offsetGet($key);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return $this->offsetExists($key);
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->data);
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->data[$offset];
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->data;
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function __get(string $key)
    {
        return $this->offsetGet($key);
    }

    /**
     * @param string $key
     * @param        $value
     */
    public function __set(string $key, $value)
    {
        $this->offsetSet($key, $value);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function __isset(string $key)
    {
        return $this->offsetExists($key);
    }
}