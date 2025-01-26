<?php

class Database {
    private static $instance = null;
    private $connection;

    private $host = 'db';
    private $dbname = 'Loja';
    private $username = 'arthur'; // Nome de usuário configurado no docker-compose.yml
    private $password = '1234'; // Senha configurada no docker-compose.yml

    private function __construct() {
        try {
            $this->connection = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection error: " . $e->getMessage();
        }
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }
}

?>