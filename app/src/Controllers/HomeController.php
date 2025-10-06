<?php

namespace App\Controllers;

use Framework\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return $this->viewWithLayout('home', [
            'title' => 'Plantastique',
            'message' => 'Bienvenue sur notre application de gestion de plantes !',
            'siteTitle' => 'Plantastique - Le réseau social des plantes éveillées'
        ]);
    }

}
