<?php
class Database {
    private static $host = 'localhost';
    private static $dbname = 'atelier_or';
    private static $username = 'root';
    private static $password = '';
    private static $pdo = null;

    public static function getPdo() {
        if (self::$pdo === null) {
            try {
                $dsn = 'mysql:host=' . self::$host . ';dbname=' . self::$dbname . ';charset=utf8mb4';
                self::$pdo = new PDO($dsn, self::$username, self::$password);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('Erreur de connexion à la base de données : ' . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}
?>
