<?php

namespace App\Controllers;

use Framework\Controller;
use Framework\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return $this->viewWithLayout('home', [
            'title' => 'Plantastique',
            'message' => 'Bienvenue sur notre application de gestion de plantes !',
            'siteTitle' => 'Plantastique - Le réseau social des plantes éveillées',
            'user' => $user
        ]);
    }

}
