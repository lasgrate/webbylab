<?php

namespace App\Controllers;

use App\Vendor\Controller;
use App\Vendor\View;

class FooterController extends Controller
{
    public function index()
    {
        return (new View('footer.tpl'))->render();
    }
}