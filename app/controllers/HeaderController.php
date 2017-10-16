<?php

namespace App\Controllers;

use App\Vendor\View;
use App\Vendor\Controller;

class HeaderController extends Controller
{
    public function index()
    {
        return (new View('header.tpl'))->render();
    }
}