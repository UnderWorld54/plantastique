<?php

namespace Framework;

class Application
{
    private Router $router;
    private Request $request;
    private Response $response;

    public function __construct()
    {
        $this->router = new Router();
        $this->request = new Request();
        $this->response = new Response();
    }

    public function getRouter(): Router
    {
        return $this->router;
    }

    public function run(): void
    {
        try {
            $route = $this->router->dispatch(
                $this->request->getMethod(),
                $this->request->getUri()
            );
            
            $this->request->setParams($route['params']);
            $response = $this->executeHandler($route['handler']);
            $this->sendResponse($response);
            
        } catch (\Exception $e) {
            $this->handleException($e);
        }
    }

    private function executeHandler($handler)
    {
        if (is_string($handler) && strpos($handler, '@') !== false) {
            return $this->executeController($handler);
        }
        
        if (is_callable($handler)) {
            return $handler($this->request, $this->response);
        }
        
        throw new \Exception("Invalid handler");
    }

    private function executeController(string $handler)
    {
        [$controllerClass, $method] = explode('@', $handler);
        $controllerClass = "App\\Controllers\\{$controllerClass}";
        
        if (!class_exists($controllerClass)) {
            throw new \Exception("Controller not found: {$controllerClass}");
        }
        
        $controller = new $controllerClass($this->request, $this->response);
        return $controller->$method();
    }

    private function sendResponse($response): void
    {
        if ($response instanceof Response) {
            $response->send();
        } else {
            echo $response;
        }
    }

    private function handleException(\Exception $e): void
    {
        if (strpos($e->getMessage(), 'Route not found') !== false) {
            $this->show404();
        } else {
            $this->show500($e->getMessage());
        }
    }

    private function show404(): void
    {
        $errorController = new \App\Controllers\ErrorController($this->request, $this->response);
        $response = $errorController->notFound();
        $this->sendResponse($response);
    }

    private function show500(string $message): void
    {
        http_response_code(500);
        echo "Error: " . $message;
    }
}


