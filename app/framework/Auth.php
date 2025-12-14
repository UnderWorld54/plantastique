<?php

namespace Framework;

class Auth
{
    public static function login(array $user): void
    {
        Session::start();
        Session::regenerate();
        Session::set('user_id', $user['id']);
        Session::set('user_name', $user['name']);
        Session::set('user_email', $user['email']);
    }

    public static function logout(): void
    {
        Session::start();
        Session::remove('user_id');
        Session::remove('user_name');
        Session::remove('user_email');
        Session::destroy();
    }

    public static function check(): bool
    {
        return Session::has('user_id');
    }

    public static function user(): ?array
    {
        if (!self::check()) {
            return null;
        }

        return [
            'id' => Session::get('user_id'),
            'name' => Session::get('user_name'),
            'email' => Session::get('user_email'),
        ];
    }

    public static function id(): ?int
    {
        return Session::get('user_id');
    }
}
