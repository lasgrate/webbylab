<?php

namespace App\Vendor;

use App\Exceptions\ResponseException;

class Action
{
    /**
     * Full controller name
     *
     * @var string
     */
    private $controller;

    /**
     * Action name.
     *
     * @var string
     */
    private $action;

    /**
     * @var \App\Vendor\Registry
     */
    private $registry;

    public function __construct(Registry $register)
    {
        $this->registry = $register;
        $this->controller = $this->getControllerName();
        $this->action = $this->getActionName();
    }

    /**
     * Execute relevant controller and action
     */
    public function execute()
    {
        $controllerClassName = 'App\Controllers\\' . $this->controller;

        try {
            $controller = new $controllerClassName($this->registry);

            if (!method_exists($controller, $this->action)) {
                throw new ResponseException('Page Not Found', 404);
            } else {
                $controller->{$this->action}();
            }

        } catch (ResponseException $e) {
            $this->registry->get('response')->setOutput($e->getResponse());
        }

        $this->registry->get('response')->output();
    }

    /**
     * Get full controller name
     *
     * @return mixed
     */
    public function getControllerName()
    {
        if (isset($this->registry->get('request')->get['controller'])) {
            return ucfirst($this->registry->get('request')->get['controller']) . CONTROLLER_POSTFIX;
        } else {
            return ucfirst(DEFAULT_CONTROLLER) . CONTROLLER_POSTFIX;
        }
    }

    /**
     * Get action name
     *
     * @return string
     */
    public function getActionName()
    {
        if (isset($this->registry->get('request')->get['action'])) {
            return $this->registry->get('request')->get['action'] . ACTION_POSTFIX;
        } else {
            return DEFAULT_ACTION . ACTION_POSTFIX;
        }
    }
}
