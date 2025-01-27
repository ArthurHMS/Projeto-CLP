<?php

require_once 'DAO.php';
require_once '../models/Venda.php';
require_once '../../config/database.php';

class DAOVenda {
    private static $instance;
    private $filePath;

    private function __construct() {
        $this->filePath = __DIR__ . '/vendas.json';
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new DAOVenda();
        }
        return self::$instance;
    }

    private function salvarDados($dados) {
        file_put_contents($this->filePath, json_encode($dados));
    }

    private function carregarDados() {
        if (!file_exists($this->filePath)) {
            return [];
        }
        $json = file_get_contents($this->filePath);
        return json_decode($json, true);
    }

    public function adicionar($venda) {
        $dados = $this->carregarDados();
        $vendaData = [
            'id' => $venda->getId(),
            'dataHora' => $venda->getDataHora()->format('Y-m-d H:i:s'),
            'itens' => []
        ];

        foreach ($venda->getItens() as $item) {
            $vendaData['itens'][] = [
                'produto_id' => $item->getProduto()->getId(),
                'nome' => $item->getProduto()->getNome(),
                'qtd' => $item->getQtd(),
                'valor' => $item->getValor()
            ];
        }

        $dados[] = $vendaData;
        $this->salvarDados($dados);
    }

    public function buscar($id) {
        $dados = $this->carregarDados();
        foreach ($dados as $vendaData) {
            if ($vendaData['id'] == $id) {
                $venda = new Venda();
                $venda->setId($vendaData['id']);
                $venda->setDataHora(DateTime::createFromFormat('Y-m-d H:i:s', $vendaData['dataHora']));
                foreach ($vendaData['itens'] as $itemData) {
                    $produto = new Produto($itemData['nome'], $itemData['valor']);
                    $produto->setId($itemData['produto_id']);
                    $venda->adicionarItem($produto, $itemData['qtd']);
                }
                return $venda;
            }
        }
        return null;
    }

    public function remover($id) {
        $dados = $this->carregarDados();
        $dados = array_filter($dados, function($vendaData) use ($id) {
            return $vendaData['id'] != $id;
        });
        $this->salvarDados($dados);
    }

    public function __toString() {
        $dados = $this->carregarDados();
        $result = "";
        foreach ($dados as $vendaData) {
            $result .= sprintf("Id: %d\tData-Hora: %s\n", $vendaData['id'], $vendaData['dataHora']);
            foreach ($vendaData['itens'] as $itemData) {
                $result .= sprintf("  Produto: %s\tQtd: %d\tValor: %.2f\n", $itemData['nome'], $itemData['qtd'], $itemData['valor']);
            }
            $result .= "\n";
        }
        return $result;
    }
}

?>