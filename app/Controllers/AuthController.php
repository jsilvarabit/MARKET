<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\User;

class AuthController
{
    public function __construct(private array $config)
    {
    }

    public function login(): void
    {
        $appName = $this->config['name'] ?? 'JVC DEVWEB Market';
        $error = null;
        $usuario = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = trim($_POST['usuario'] ?? '');
            $senha = $_POST['senha'] ?? '';

            $user = User::findByCredentials($usuario, $senha);

            if ($user !== null) {
                $_SESSION['user'] = [
                    'id' => $user['USU_ID'],
                    'login' => $user['USU_LOGIN'],
                    'nome' => $user['USU_NOME'],
                    'email' => $user['USU_EMAIL'],
                ];

                header('Location: index.php?route=dashboard');
                exit;
            }

            $error = 'Usuario ou senha invalidos.';
        }

        require dirname(__DIR__) . '/Views/auth/login.php';
    }

    public function dashboard(): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?route=login');
            exit;
        }

        $appName = $this->config['name'] ?? 'JVC DEVWEB Market';
        $user = $_SESSION['user'];

        require dirname(__DIR__) . '/Views/auth/dashboard.php';
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();

        header('Location: index.php?route=login');
        exit;
    }
}
