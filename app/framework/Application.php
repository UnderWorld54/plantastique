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
            $method = $this->request->getMethod();
            $uri = $this->request->getUri();
            
            $route = $this->router->dispatch($method, $uri);
            
            $this->request->setParams($route['params']);
            
            $handler = $route['handler'];
            
            if (is_string($handler) && strpos($handler, '@') !== false) {

                [$controllerClass, $method] = explode('@', $handler);
                $controllerClass = "App\\Controllers\\{$controllerClass}";
                
                if (class_exists($controllerClass)) {
                    $controller = new $controllerClass($this->request, $this->response);
                    $response = $controller->$method();
                } else {
                    throw new \Exception("Controller not found: {$controllerClass}");
                }
            } elseif (is_callable($handler)) {
                $response = $handler($this->request, $this->response);
            } else {
                throw new \Exception("Invalid handler");
            }
            
            if ($response instanceof Response) {
                $response->send();
            } else {
                echo $response;
            }
            
        } catch (\Exception $e) {
            $this->handleException($e);
        }
    }

    private function handleException(\Exception $e): void
    {
        http_response_code(500);
        echo "Error: " . $e->getMessage();
    }
}

