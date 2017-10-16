<?php

namespace App\Exceptions;

class PageNotFoundException extends \Exception
{
    public function getViewName()
    {
        return "errors/{$this->getMessage()}.tpl";
    }
}