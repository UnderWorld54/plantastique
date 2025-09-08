<?php

namespace Framework;

class Response
{
    private int $statusCode = 200;
    private array $headers = [];
    private $content = '';

    public function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function setHeader(string $name, string $value): self
    {
        $this->headers[$name] = $value;
        return $this;
    }

    public function setContent($content): self
    {
        $this->content = $content;
        return $this;
    }

    public function json(array $data, int $statusCode = 200): self
    {
        $this->setHeader('Content-Type', 'application/json');
        $this->setStatusCode($statusCode);
        $this->setContent(json_encode($data));
        return $this;
    }

    public function view(string $view, array $data = []): self
    {
        $this->setHeader('Content-Type', 'text/html');
        $this->setContent($this->renderView($view, $data));
        return $this;
    }

    public function redirect(string $url, int $statusCode = 302): self
    {
        $this->setStatusCode($statusCode);
        $this->setHeader('Location', $url);
        return $this;
    }

    private function renderView(string $view, array $data = []): string
    {
        extract($data);
        
        // Buffer de sortie pour le contenu
        ob_start();
        
        $viewPath = __DIR__ . '/../src/Views/' . $view . '.php';
        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            throw new \Exception("View not found: {$view}");
        }
        
        return ob_get_clean();
    }

    public function send(): void
    {
        http_response_code($this->statusCode);
        
        foreach ($this->headers as $name => $value) {
            header("{$name}: {$value}");
        }
        
        echo $this->content;
    }
}
