<?php

namespace Framework;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $connection = null;

    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            try {
                $host = getenv('DB_HOST') ?: $_ENV['DB_HOST'] ?? null;
                $port = getenv('DB_PORT') ?: $_ENV['DB_PORT'] ?? null;
                $dbname = getenv('DB_NAME') ?: $_ENV['DB_NAME'] ?? null;
                $user = getenv('DB_USER') ?: $_ENV['DB_USER'] ?? null;
                $password = getenv('DB_PASSWORD') ?: $_ENV['DB_PASSWORD'] ?? null;

                $dsn = "mysql:host=$host;port=$port;dbname=$dbname";
                self::$connection = new PDO($dsn, $user, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);
            } catch (PDOException $e) {
                throw new \Exception("Database connection failed: " . $e->getMessage());
            }
        }

        return self::$connection;
    }

    // insérer un enregistrement et retourner l'ID
    public static function create(string $table, array $data): int|false
    {
        $pdo = self::getConnection();

        $columns = array_keys($data);
        $placeholders = array_map(fn($col) => ":$col", $columns);

        $sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s) RETURNING id",
            $table,
            implode(', ', $columns),
            implode(', ', $placeholders)
        );

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute($data);
            $result = $stmt->fetch();
            return (int) $pdo->lastInsertId();
        } catch (PDOException $e) {
            error_log("Database create error: " . $e->getMessage());
            return false;
        }
    }

    // TODO: Ajouter les methodes find et update ici 

    // supprimer un enregistrement par ID
    public static function deleteById(string $table, int $id): bool
    {
        $pdo = self::getConnection();

        $sql = "DELETE FROM $table WHERE id = :id";

        try {
            $stmt = $pdo->prepare($sql);
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            error_log("Database deleteById error: " . $e->getMessage());
            return false;
        }
    }

    // supprimer des enregistrements par conditions
    public static function delete(string $table, array $conditions): bool
    {
        $pdo = self::getConnection();

        $whereClauses = [];
        foreach (array_keys($conditions) as $column) {
            $whereClauses[] = "$column = :$column";
        }

        $sql = sprintf(
            "DELETE FROM %s WHERE %s",
            $table,
            implode(' AND ', $whereClauses)
        );

        try {
            $stmt = $pdo->prepare($sql);
            return $stmt->execute($conditions);
        } catch (PDOException $e) {
            error_log("Database delete error: " . $e->getMessage());
            return false;
        }
    }

    // requête personnalisée avec paramètres
    public static function query(string $sql, array $params = []): array|false
    {
        $pdo = self::getConnection();

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Database query error: " . $e->getMessage());
            return false;
        }
    }

    // exécuter une commande personnalisée (INSERT, UPDATE, DELETE)
    public static function execute(string $sql, array $params = []): bool
    {
        $pdo = self::getConnection();

        try {
            $stmt = $pdo->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log("Database execute error: " . $e->getMessage());
            return false;
        }
    }

    public static function findById(string $table, int $id) {

    }
}
