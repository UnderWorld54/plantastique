<?php

namespace App\Controllers;

use Framework\Controller;

class UserController extends Controller
{
    public function show()
    {
        $id = $this->param('id');
        return $this->viewWithLayout('user', [
            'id' => $id,
            'title' => "Profil Utilisateur #{$id}",
            'siteTitle' => "Plantastique - Profil de {$id}"
        ]);
    }

    public function list()
    {
        return $this->viewWithLayout('users', [
            'title' => "Liste des Utilisateurs"
        ]);
    }
}
