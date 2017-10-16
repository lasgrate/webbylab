<?php

namespace App\Vendor;

use App\Exceptions\PageNotFoundException;

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
     *
     *
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
     *
     * @return mixed
     */
    public function execute()
    {
        $controllerClassName = 'App\Controller\\' . $this->controller;

        try {
            $controller = new $controllerClassName($this->registry);

            if (!method_exists($controller, $this->action)) {
                throw new PageNotFoundException(404);
            } else {
                $this->preAction($controller);
                $output = $controller->{$this->action}();
            }

        } catch (PageNotFoundException $e) {
            $output = (new View($e->getViewName()))->render();
        }

        $this->registry->get('response')->setOutput($output);
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

    /**
     * Execute pre action.
     *
     * @param $controller
     */
    public function preAction($controller) {
        $controller->preAction($this->action);
    }
}
