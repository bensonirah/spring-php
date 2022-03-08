<?php

namespace App\Http\Middlewares;

interface RequestHandlerInterface
{
    public function __invoke(RequestInterface $request): ResponseInterface;
}