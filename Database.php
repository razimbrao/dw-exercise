<?php
class Database {
    private static ?Database $instance = null;
    private ?PDO $pdo = null;

    private function __construct() {
        try {
            $this->pdo = new PDO("sqlite:" . __DIR__ . "/database.sqlite");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance(): Database {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): PDO {
        return $this->pdo;
    }

    private function __clone() {}
    private function __wakeup() {}
}

// Usage example:
//$db = Database::getInstance()->getConnection();
