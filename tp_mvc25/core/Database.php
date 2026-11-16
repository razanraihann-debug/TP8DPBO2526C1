<?php
/**
 * Koneksi database (Singleton, PDO).
 */
class Database
{
    private static ?PDO $pdo = null;

    public static function connect(): PDO
    {
        if (self::$pdo === null) {
            $c = require __DIR__ . '/../config/config.php';
            $c = $c['db'];
            $dsn = "mysql:host={$c['host']};dbname={$c['name']};charset={$c['charset']}";
            try {
                self::$pdo = new PDO($dsn, $c['user'], $c['pass'], [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]);
            } catch (PDOException $e) {
                http_response_code(500);
                die('Connection failed: ' . htmlspecialchars($e->getMessage()));
            }
        }
        return self::$pdo;
    }

    /** Untuk keperluan pengujian (inject koneksi lain). */
    public static function setConnection(PDO $pdo): void
    {
        self::$pdo = $pdo;
    }
}
