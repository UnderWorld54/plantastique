<?php

namespace App\Controllers;

use Framework\Controller;
use Framework\Database;
use Framework\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirect('/');
        }

        return $this->viewWithLayout('login', [
            'title' => 'Connexion',
            'siteTitle' => 'Plantastique - Connexion'
        ]);
    }

    public function login()
    {
        $email = $this->request->input('email');
        $password = $this->request->input('password');

        if (!$email || !$password) {
            return $this->redirect('/login');
        }

        $users = Database::query("SELECT * FROM users WHERE email = :email", [
            'email' => $email
        ]);

        if (!$users || count($users) === 0) {
            return $this->redirect('/login');
        }

        $user = $users[0];

        if (!password_verify($password, $user['password'])) {
            return $this->redirect('/login');
        }

        Auth::login($user);

        return $this->redirect('/');
    }

    public function logout()
    {
        Auth::logout();
        return $this->redirect('/login');
    }
}
