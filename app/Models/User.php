<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

class User
{
    public function __construct(
        public string $username,
        public string $password
    ) {
    }

    public static function findByCredentials(string $login, string $password): ?array
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare(
            'SELECT USU_ID, USU_LOGIN, USU_NOME, USU_EMAIL
             FROM usuarios
             WHERE USU_LOGIN = :login
             AND USU_SENHA = :password
             LIMIT 1'
        );

        $stmt->execute([
            ':login' => $login,
            ':password' => $password,
        ]);

        $user = $stmt->fetch();

        return $user ?: null;
    }
}
