<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

class User
{
    private static bool $primeiroAcessoColumnChecked = false;

    public function __construct(
        public string $username,
        public string $password
    ) {
    }

    private static function ensurePrimeiroAcessoColumn(): void
    {
        if (self::$primeiroAcessoColumnChecked) {
            return;
        }

        $pdo = Database::connect();
        $columns = $pdo->query('PRAGMA table_info(usuarios)')->fetchAll();
        $hasColumn = false;

        foreach ($columns as $column) {
            if (($column['name'] ?? '') === 'USU_PRIMEIRO_ACESSO') {
                $hasColumn = true;
                break;
            }
        }

        if (!$hasColumn) {
            $pdo->exec('ALTER TABLE usuarios ADD COLUMN USU_PRIMEIRO_ACESSO INTEGER NOT NULL DEFAULT 0');
        }

        self::$primeiroAcessoColumnChecked = true;
    }

    public static function findByCredentials(string $login, string $password): ?array
    {
        self::ensurePrimeiroAcessoColumn();

        $pdo = Database::connect();
        $stmt = $pdo->prepare(
            'SELECT USU_ID, USU_LOGIN, USU_NOME, USU_EMAIL, USU_PRIMEIRO_ACESSO
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

    public static function getAllUsers(): array
    {
        self::ensurePrimeiroAcessoColumn();

        $pdo = Database::connect();
        $stmt = $pdo->query('SELECT USU_ID, USU_LOGIN, USU_NOME, USU_EMAIL, USU_PRIMEIRO_ACESSO FROM usuarios ORDER BY USU_NOME ASC');
        return $stmt->fetchAll();
    }

    public static function findById(int $id): ?array
    {
        self::ensurePrimeiroAcessoColumn();

        $pdo = Database::connect();
        $stmt = $pdo->prepare(
            'SELECT USU_ID, USU_LOGIN, USU_NOME, USU_EMAIL, USU_PRIMEIRO_ACESSO
             FROM usuarios
             WHERE USU_ID = :id
             LIMIT 1'
        );

        $stmt->execute([':id' => $id]);
        $user = $stmt->fetch();

        return $user ?: null;
    }

    public static function updateUser(int $id, string $nome, string $email): bool
    {
        self::ensurePrimeiroAcessoColumn();

        $pdo = Database::connect();
        $stmt = $pdo->prepare(
            'UPDATE usuarios
             SET USU_NOME = :nome,
                 USU_EMAIL = :email
             WHERE USU_ID = :id'
        );

        return $stmt->execute([
            ':id' => $id,
            ':nome' => $nome,
            ':email' => $email,
        ]);
    }

    public static function createUser(string $nome, string $email, string $login, string $senha): bool
    {
        self::ensurePrimeiroAcessoColumn();

        $pdo = Database::connect();
        $stmt = $pdo->prepare(
            'INSERT INTO usuarios (USU_NOME, USU_EMAIL, USU_LOGIN, USU_SENHA, USU_PRIMEIRO_ACESSO)
             VALUES (:nome, :email, :login, :senha, 1)'
        );

        return $stmt->execute([
            ':nome' => $nome,
            ':email' => $email,
            ':login' => $login,
            ':senha' => $senha,
        ]);
    }

    public static function updateFirstAccessPassword(int $id, string $password): bool
    {
        self::ensurePrimeiroAcessoColumn();

        $pdo = Database::connect();
        $stmt = $pdo->prepare(
            'UPDATE usuarios
             SET USU_SENHA = :password,
                 USU_PRIMEIRO_ACESSO = 0
             WHERE USU_ID = :id'
        );

        return $stmt->execute([
            ':id' => $id,
            ':password' => $password,
        ]);
    }
}
