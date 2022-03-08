<?php

namespace App\Http\Middlewares;

interface RequestBus
{
    public function dispatch(RequestInterface $request): ResponseInterface;
}