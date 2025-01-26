<?php

require_once 'DAO.php';
require_once '../models/Venda.php';
require_once '../../config/database.php';

class DAOVenda {
    private static $instance;
    private $connection;

    private function __construct() {
        $this->connection = Database::getInstance()->getConnection();
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new DAOVenda();
        }
        return self::$instance;
    }

    public function adicionar($venda) {
        $sql = "INSERT INTO vendas (data_hora) VALUES (:data_hora)";
        $stmt = $this->connection->prepare($sql);
        $dataHora = $venda->getDataHora()->format('Y-m-d H:i:s');
        $stmt->bindParam(':data_hora', $dataHora);
        $stmt->execute();
        $vendaId = $this->connection->lastInsertId();

        foreach ($venda->getItens() as $item) {
            $sql = "INSERT INTO itens_venda (venda_id, produto_id, qtd, valor) VALUES (:venda_id, :produto_id, :qtd, :valor)";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':venda_id', $vendaId);
            $stmt->bindParam(':produto_id', $item->getProduto()->getId());
            $stmt->bindParam(':qtd', $item->getQtd());
            $stmt->bindParam(':valor', $item->getValor());
            $stmt->execute();
        }
    }

    public function buscar($id) {
        $sql = "SELECT * FROM vendas WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Venda');
        return $stmt->fetch();
    }

    public function remover($id) {
        $sql = "DELETE FROM vendas WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function __toString() {
        $sql = "SELECT * FROM vendas";
        $stmt = $this->connection->query($sql);
        $vendas = $stmt->fetchAll(PDO::FETCH_CLASS, 'Venda');
        $result = "";
        foreach ($vendas as $venda) {
            $result .= $venda->__toString() . "\n";
        }
        return $result;
    }
}

?>