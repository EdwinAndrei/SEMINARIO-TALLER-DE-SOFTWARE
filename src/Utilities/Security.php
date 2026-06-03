<?php

namespace Utilities;

class Security
{
    private function __construct() {}
    private function __clone() {}

public static function login(int $userId, string $userName, string $userEmail, string $userRol): void
    {
        $_SESSION['login'] = [
            'isLogged'  => true,
            'userId'    => $userId,
            'userName'  => $userName,
            'userEmail' => $userEmail,
            'userRol'   => $userRol,
        ];
    }

    public static function logout(): void
    {
        unset($_SESSION['login']);
    }

    public static function isLogged(): bool
    {
        return !empty($_SESSION['login']['isLogged']);
    }
    public static function getUserRole(): string
{
    return $_SESSION['login']['userRol'] ?? '';
}

    public static function getUser(): array|false
    {
        return $_SESSION['login'] ?? false;
    }

    public static function getUserId(): int
    {
        return (int) ($_SESSION['login']['userId'] ?? 0);
    }
}
