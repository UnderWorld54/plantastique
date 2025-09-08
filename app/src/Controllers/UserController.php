<?php

namespace App\Controllers;

use Framework\Controller;

class UserController extends Controller
{
    public function show()
    {
        $id = $this->param('id');
        return $this->view('user', [
            'id' => $id,
            'title' => "Profil de la plante #{$id}"
        ]);
    }
}
