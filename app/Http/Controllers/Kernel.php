<?php

namespace App\Http\Controllers;

abstract class Kernel
{
    protected $routeMiddleware = [
        // другие middleware
       'admin' => \App\Http\Middleware\AdminMiddleware::class,
       
    ];
}
