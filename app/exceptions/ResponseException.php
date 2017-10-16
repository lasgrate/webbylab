<?php

namespace App\Exceptions;

use App\Vendor\View;

class ResponseException extends \Exception
{
    public function getView()
    {
        return "errors/{$this->getCode()}.tpl";
    }

    public function getResponse() {
        return (new View($this->getView(), [
            'code' => $this->getCode(),
            'message' => $this->getMessage(),
        ]))->render();
    }
}