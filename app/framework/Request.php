<?php

namespace Framework;

class Request
{
    private array $params = [];
    private array $data = [];
    private array $headers = [];

    public function __construct()
    {
        $this->data = array_merge($_GET, $_POST);
        $this->headers = getallheaders() ?: [];
    }

    public function setParams(array $params): void
    {
        $this->params = $params;
    }

    public function getParam(string $key, $default = null)
    {
        return $this->params[$key] ?? $default;
    }

    public function get(string $key, $default = null)
    {
        return $this->data[$key] ?? $default;
    }

    public function post(string $key, $default = null)
    {
        return $_POST[$key] ?? $default;
    }

    public function getHeader(string $name, $default = null)
    {
        $name = strtolower($name);
        foreach ($this->headers as $key => $value) {
            if (strtolower($key) === $name) {
                return $value;
            }
        }
        return $default;
    }

    public function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'] ?? 'GET';
    }

    public function getUri(): string
    {
        return $_SERVER['REQUEST_URI'] ?? '/';
    }

    public function isJson(): bool
    {
        return $this->getHeader('content-type') === 'application/json';
    }

    public function getJsonData(): array
    {
        if ($this->isJson()) {
            $input = file_get_contents('php://input');
            return json_decode($input, true) ?: [];
        }
        return [];
    }

    public function all(): array
    {
        return array_merge($this->params, $this->data);
    }

    // récup une entrée, que ce soit en JSON ou en formulaire. 
    // voir si possible d'unifier getJsonData et input
    public function input(string $key, $default = null)
    {
        if ($this->isJson()) {
            $jsonData = $this->getJsonData();
            return $jsonData[$key] ?? $default;
        }
        return $this->get($key, $default);
    }
}

