<?php

namespace App\Vendor;

/**
 * Class Registry implements simple registry pattern for object storage.
 * @package App\System
 */
final class Registry
{
    /**
     * Object storage.
     * @var array
     */
    private $data = [];

    /**
     * Get object from the storage.
     *
     * @param $key
     * @return mixed|null
     */
    public function get($key)
    {
        return (isset($this->data[$key]) ? $this->data[$key] : null);
    }

    /**
     * Put an object into the storage.
     *
     * @param $key
     * @param $value
     */
    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * Check if specify object exist
     *
     * @param $key
     * @return bool
     */
    public function has($key)
    {
        return isset($this->data[$key]);
    }
}
