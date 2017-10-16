<?php

namespace App\Vendor;

class Controller
{
    /**
     * @var Registry
     */
    protected $registry;

    /**
     * Controller storage.
     *
     * @var
     */
    protected $storage;

    public function __construct(Registry $registry, $storage = [])
    {
        $this->registry = $registry;
        $this->storage = $storage;
        $this->beforeAction();
    }

    /**
     * Getter for register`s object
     *
     * @param $key
     * @return mixed|null
     */
    public function __get($key)
    {
        return $this->registry->get($key);
    }

    /**
     * Setter for register`s object
     *
     * @param $key
     * @param $value
     */
    public function __set($key, $value)
    {
        $this->registry->set($key, $value);
    }

    /**
     * Pre action method.
     */
    public function beforeAction() {}
}
