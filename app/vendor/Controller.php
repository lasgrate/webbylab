<?php

namespace App\Vendor;

class Controller
{
    /**
     * @var Registry
     */
    protected $registry;

    protected $storage;

    public function __construct(Registry $registry)
    {
        $this->registry = $registry;
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
     *
     * @param $actionName
     */
    public function preAction($actionName) {}
}
