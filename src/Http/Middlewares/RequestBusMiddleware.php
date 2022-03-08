<?php

namespace App\Http\Middlewares;

use App\Http\Response;

class RequestBusMiddleware implements RequestHandlerInterface
{
    /**
     * List of request handler
     *
     * @var array
     */
    private $requestHandlers;

    public function __construct(iterable $requestHandlers)
    {
        foreach ($requestHandlers as $handler) {
            $this->requestHandlers[$this->commandFrom($handler)] = $handler;
        }
    }

    public function __invoke(RequestInterface $request): ResponseInterface
    {
        try {
            $handler = $this->getHandler(get_class($request));
            return $handler($request);
        } catch (\Throwable $t) {
            return new Response();
        }
    }

    /**
     * Get an handler from className of a given command
     *
     *
     * @param string $commandClassName The className of a command
     * @return callable The command handler
     * @throws \InvalidArgumentException
     */
    private function getHandler(string $commandClassName): callable
    {
        if (!$handler = $this->requestHandlers[$commandClassName]) {
            throw new \InvalidArgumentException(
                sprintf("Unable to find handler for the command %s", $commandClassName),
                400
            );
        }
        return $handler;
    }

    private function commandFrom(object $handler): string
    {
        $reflectionMethod = new \ReflectionMethod(get_class($handler), '__invoke');
        $parameters = $reflectionMethod->getParameters();
        return $parameters[0]->getClass()->getName();
    }
}