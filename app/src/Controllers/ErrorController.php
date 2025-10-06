<?php

namespace App\Controllers;

use Framework\Controller;

class ErrorController extends Controller
{
    public function notFound()
    {
        http_response_code(404);
        return $this->view('errors/404', [
            'title' => "Hehehe tu t'es perdu...",
            'message' => 'Va te faire voir ailleurs que chez moi ! 😡',
        ]);
    }
}

