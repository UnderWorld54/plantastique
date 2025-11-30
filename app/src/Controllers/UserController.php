<?php

namespace App\Controllers;

use Framework\Controller;
use Framework\Database;

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

    public function showRegister()
    {
        return $this->viewWithLayout('register', [
            'title' => "Création compte",
            'siteTitle' => "Plantastique - Inscription"
        ]);
    }

    public function register()
    {
        $email = $this->request->input('email');
        $password = $this->request->input('password');
        $name = $this->request->input('name');

        if (!$email || !$password || !$name) {
            return $this->json(['error' => 'Tous les champs sont requis'], 400);
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $userId = Database::create('users', [
            'email' => $email,
            'password' => $hashedPassword,
            'name' => $name
        ]);

        // test db
        if ($userId === false) {
            return $this->json(['error' => 'Erreur lors de la création du compte'], 500);
        }

        return $this->json([
            'message' => 'Compte créé avec succès',
            'user_id' => $userId
        ], 201);
    }
}
