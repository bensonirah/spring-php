<?php

namespace App\Http\Middlewares;

interface HttpMiddlewareInterface
{
    public function __invoke(RequestInterface $request,callable $next):ResponseInterface;
}