<?php

namespace App\Core;

class Route
{
    public function __construct(public $method, public $url, public $callback)
    {
        throw new \Exception('Not implemented');
    }
}
