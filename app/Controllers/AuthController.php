<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Product;
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
        $primeiroAcesso = isset($_SESSION['primeiro_acesso_user_id']);
        $primeiroAcessoError = $_SESSION['primeiro_acesso_error'] ?? null;
        unset($_SESSION['primeiro_acesso_error']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = trim($_POST['usuario'] ?? '');
            $senha = $_POST['senha'] ?? '';

            $user = User::findByCredentials($usuario, $senha);

            if ($user !== null) {
                if ((int) ($user['USU_PRIMEIRO_ACESSO'] ?? 0) === 1) {
                    $_SESSION['primeiro_acesso_user_id'] = $user['USU_ID'];
                    $primeiroAcesso = true;

                    require dirname(__DIR__) . '/Views/auth/login.php';
                    return;
                }

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

    public function confirmarPrimeiroAcesso(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?route=login');
            exit;
        }

        $userId = (int) ($_SESSION['primeiro_acesso_user_id'] ?? 0);
        $novaSenha = $_POST['nova_senha'] ?? '';
        $confirmarNovaSenha = $_POST['confirmar_nova_senha'] ?? '';

        if ($userId <= 0) {
            header('Location: index.php?route=login');
            exit;
        }

        if ($novaSenha === '' || $confirmarNovaSenha === '' || $novaSenha !== $confirmarNovaSenha) {
            $_SESSION['primeiro_acesso_error'] = 'Informe senhas iguais para concluir o primeiro acesso.';
            header('Location: index.php?route=login');
            exit;
        }

        User::updateFirstAccessPassword($userId, $novaSenha);
        $user = User::findById($userId);
        unset($_SESSION['primeiro_acesso_user_id']);

        if ($user === null) {
            header('Location: index.php?route=login');
            exit;
        }

        $_SESSION['user'] = [
            'id' => $user['USU_ID'],
            'login' => $user['USU_LOGIN'],
            'nome' => $user['USU_NOME'],
            'email' => $user['USU_EMAIL'],
        ];

        header('Location: index.php?route=dashboard');
        exit;
    }

    public function dashboard(): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?route=login');
            exit;
        }

        $appName = $this->config['name'] ?? 'JVC DEVWEB Market';
        $user = $_SESSION['user'];
        $lowStockProducts = Product::lowStock(20);

        require dirname(__DIR__) . '/Views/auth/dashboard.php';
    }

    public function gerenciarUsuarios(): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?route=login');
            exit;
        }

        $appName = $this->config['name'] ?? 'JVC DEVWEB Market';
        $user = $_SESSION['user'];
        $users = User::getAllUsers();
        $usuariosFlash = $_SESSION['usuarios_flash'] ?? null;
        unset($_SESSION['usuarios_flash']);
      
        require dirname(__DIR__) . '/Views/auth/gerenciarUsuarios.php';
    }

    public function cadastrarUsuario(): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?route=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?route=gerenciarUsuarios');
            exit;
        }

        $nome = trim($_POST['nome'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $login = trim($_POST['login'] ?? '');

        if ($nome === '' || $email === '' || $login === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['usuarios_flash'] = [
                'type' => 'danger',
                'message' => 'Informe nome, email valido e login para cadastrar o usuario.',
            ];

            header('Location: index.php?route=gerenciarUsuarios');
            exit;
        }

        try {
            User::createUser($nome, $email, $login, $login);

            $_SESSION['usuarios_flash'] = [
                'type' => 'success',
                'message' => 'Usuario cadastrado com sucesso. A senha inicial e igual ao login.',
            ];
        } catch (\Throwable) {
            $_SESSION['usuarios_flash'] = [
                'type' => 'danger',
                'message' => 'Nao foi possivel cadastrar o usuario. Verifique se login ou email ja estao em uso.',
            ];
        }

        header('Location: index.php?route=gerenciarUsuarios');
        exit;
    }

    public function editarUsuario(): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?route=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?route=gerenciarUsuarios');
            exit;
        }

        $id = (int) ($_POST['id'] ?? 0);
        $nome = trim($_POST['nome'] ?? '');
        $email = trim($_POST['email'] ?? '');

        if ($id <= 0 || $nome === '' || $email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['usuarios_flash'] = [
                'type' => 'danger',
                'message' => 'Informe um nome e um email valido para editar o usuario.',
            ];

            header('Location: index.php?route=gerenciarUsuarios');
            exit;
        }

        try {
            User::updateUser($id, $nome, $email);

            if ((int) ($_SESSION['user']['id'] ?? 0) === $id) {
                $_SESSION['user']['nome'] = $nome;
                $_SESSION['user']['email'] = $email;
            }

            $_SESSION['usuarios_flash'] = [
                'type' => 'success',
                'message' => 'Usuario atualizado com sucesso.',
            ];
        } catch (\Throwable) {
            $_SESSION['usuarios_flash'] = [
                'type' => 'danger',
                'message' => 'Nao foi possivel atualizar o usuario. Verifique se o email ja esta em uso.',
            ];
        }

        header('Location: index.php?route=gerenciarUsuarios');
        exit;
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();

        header('Location: index.php?route=login');
        exit;
    }
}
