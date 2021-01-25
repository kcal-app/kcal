<?php

namespace App\Http\Middleware;

use Fideloper\Proxy\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    /**
     * {@inheritdoc}
     */
    protected $proxies;

    /**
     * {@inheritdoc}
     */
    protected $headers = Request::HEADER_X_FORWARDED_ALL;
}
