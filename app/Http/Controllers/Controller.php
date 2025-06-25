<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public $code    = 200;
    public $msg     = '';
    public $data    = [];
}
