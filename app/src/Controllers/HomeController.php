<?php

namespace App\Controllers;

use Framework\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return $this->view('home', [
            'title' => 'Plantastique',
            'message' => 'Hello World!',
        ]);
    }
}
