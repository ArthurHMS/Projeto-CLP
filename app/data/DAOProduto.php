<?php

require_once '../app/data/DAO.php';
require_once '../app/models/Produto.php';
require_once '../config/database.php';

class DAOProduto {
    private static $instance;

    private function __construct() {
        $this->connection = Database::getInstance()->getConnection();
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new DAOProduto();
        }
        return self::$instance;
    }

    public function adicionar($produto) {
        $sql = "INSERT INTO produtos (nome, valor) VALUES (:nome, :valor)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':nome', $produto->getNome());
        $stmt->bindParam(':valor', $produto->getValor());
        $stmt->execute();
    }

    public function buscar($id) {
        $sql = "SELECT * FROM produtos WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Produto');
        return $stmt->fetch();
    }

    public function buscarPorNome($nome) {
        $sql = "SELECT * FROM produtos WHERE nome = :nome";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Produto');
        return $stmt->fetch();
    }

    public function remover($id) {
        $sql = "DELETE FROM produtos WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function removerPorNome($nome) {
        $sql = "DELETE FROM produtos WHERE nome = :nome";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->execute();
    }

    public function __toString() {
        $sql = "SELECT * FROM produtos";
        $stmt = $this->connection->query($sql);
        $produtos = $stmt->fetchAll(PDO::FETCH_CLASS, 'Produto');
        $result = "";
        foreach ($produtos as $produto) {
            $result .= $produto->__toString() . "\n";
        }
        return $result;
    }
}

?>