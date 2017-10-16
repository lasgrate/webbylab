<?php

namespace App\Vendor;

class DB
{
    /**
     * @var DB
     */
    private $adaptor;

    public function __construct(
        $adaptor = DB_ADAPTER,
        $hostname = DB_HOST,
        $username = DB_USER,
        $password = DB_PASSWORD,
        $database = DB_NAME,
        $port = 3306
    ) {
        // Get needed adapter
        $class = 'App\Vendor\DB\\' . $adaptor;

        if (class_exists($class)) {
            $this->adaptor = new $class($hostname, $username, $password, $database, $port);
        } else {
            throw new \Exception('Error: Could not load database adaptor ' . $adaptor . '!');
        }
    }

    /**
     * Execute according query
     *
     * @param $sql
     * @param array $params
     * @return mixed
     */
    public function query($sql, $params = array())
    {
        return $this->adaptor->query($sql, $params);
    }

    /**
     * Custom safety escape
     *
     * @param $value
     * @return mixed
     */
    public function escape($value)
    {
        return $this->adaptor->escape($value);
    }

    public function getLastId()
    {
        return $this->adaptor->getLastId();
    }
}