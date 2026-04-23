<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

class Product
{
    public static function lowStock(int $limit = 20): array
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare(
            'SELECT PDT_ID, PDT_DESCRICAO, PDT_PRECO, PDT_QUANTIDADE
             FROM produtos
             WHERE PDT_QUANTIDADE < :limit
             ORDER BY PDT_QUANTIDADE ASC, PDT_DESCRICAO ASC'
        );

        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
