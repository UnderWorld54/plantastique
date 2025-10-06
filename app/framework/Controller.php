<?php

namespace Framework;

abstract class Controller
{
    protected Request $request;
    protected Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    protected function view(string $view, array $data = []): Response
    {
        return $this->response->view($view, $data);
    }

    protected function viewWithLayout(string $view, array $data = [], string $layout = 'layout'): Response
    {
        return $this->response->viewWithLayout($view, $data, $layout);
    }

    protected function json(array $data, int $statusCode = 200): Response
    {
        return $this->response->json($data, $statusCode);
    }

    protected function redirect(string $url, int $statusCode = 302): Response
    {
        return $this->response->redirect($url, $statusCode);
    }

    protected function param(string $key, $default = null)
    {
        return $this->request->getParam($key, $default);
    }

    protected function input(string $key, $default = null)
    {
        return $this->request->get($key, $default);
    }
}

