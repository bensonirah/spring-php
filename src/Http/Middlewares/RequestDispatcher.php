<?php

namespace App\Http\Middlewares;

use App\Http\Response;

class RequestDispatcher implements RequestBus
{
    /**
     * @var RequestHandlerInterface
     */
    private $next;

    public function __construct(iterable $middlewares, RequestHandlerInterface $requestHandler)
    {
        $this->next = $requestHandler;
        // Setting up middlewares stack
        foreach ($middlewares as $middleware) {
            $temp = $this->next;
            $this->next = function (RequestInterface $request) use ($middleware, $temp) {
                return $middleware($request, $temp);
            };
        }
    }

    public function dispatch(RequestInterface $request): ResponseInterface
    {
        return call_user_func($this->next, $request);
    }
}