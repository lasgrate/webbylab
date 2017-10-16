<?php

namespace App\Vendor;

/**
 * Class Request is for storage request data.
 * @package App\System
 */
class Request
{
    public $get = array();

    public $post = array();

    public $cookie = array();

    public $files = array();

    public $server = array();

    public function __construct()
    {
        $this->get = $this->clean($_GET);
        $this->post = $this->clean($_POST);
        $this->request = $this->clean($_REQUEST);
        $this->cookie = $this->clean($_COOKIE);
        $this->files = $this->clean($_FILES);
        $this->server = $this->clean($_SERVER);
    }

    /**
     * Pass all key and value through htmlspecialchars
     *
     * @param $data
     * @return array|string
     */
    public function clean($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                unset($data[$key]);

                $data[$this->clean($key)] = $this->clean($value);
            }
        } else {
            // Second param : ENT_COMPAT - convert double-quotes and leave single-quotes alone,
            // Third param : 'UTF-8' - set encoding.
            $data = htmlspecialchars($data, ENT_COMPAT, 'UTF-8');
        }

        return $data;
    }

    public function __get($parameter)
    {
        if (array_key_exists($parameter, $this->get)) {
            return $this->get[$parameter];
        } elseif (array_key_exists($parameter, $this->post)) {
            return $this->post[$parameter];
        } else {
            return null;
        }
    }
}
