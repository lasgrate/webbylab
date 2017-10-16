<?php

namespace App\Vendor;

class Model
{
    /**
     * @var DB
     */
    protected $db;

    /**
     * @var Request
     */
    protected $request;

    public function __construct(Registry $registry)
    {
        $this->db = $registry->get('db');
        $this->request = $registry->get('request');
    }
}
