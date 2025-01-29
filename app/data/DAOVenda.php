<?php

require_once 'DAO.php';
require_once __DIR__ . '/../models/Venda.php';
require_once __DIR__ . '/../models/Produto.php';

class DAOVenda {
    private static $instance;
    private $filePath;

    private function __construct() {
        $this->filePath = __DIR__ . '/vendas.json';
        if (!file_exists($this->filePath)) {
            file_put_contents($this->filePath, json_encode([]));
        }
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new DAOVenda();
        }
        return self::$instance;
    }

    private function salvarDados($dados) {
        file_put_contents($this->filePath, json_encode($dados, JSON_PRETTY_PRINT));
    }

    private function carregarDados() {
        $json = file_get_contents($this->filePath);
        return json_decode($json, true);
    }

    public function adicionar($venda) {
        $dados = $this->carregarDados();
        $vendaData = [
            'dataHora' => $venda->getDataHora()->format('Y-m-d H:i:s'),
            'itens' => []
        ];

        foreach ($venda->getItens() as $item) {
            $vendaData['itens'][] = [
                'nome' => $item->getProduto()->getNome(),
                'qtd' => $item->getQtd(),
                'valor' => $item->getValor()
            ];
        }

        $dados[] = $vendaData;
        $this->salvarDados($dados);
    }

    public function buscar($dataHora) {
        $dados = $this->carregarDados();
        foreach ($dados as $vendaData) {
            if ($vendaData['dataHora'] == $dataHora) {
                $venda = new Venda();
                $venda->setDataHora(DateTime::createFromFormat('Y-m-d H:i:s', $vendaData['dataHora']));
                foreach ($vendaData['itens'] as $itemData) {
                    $produto = new Produto($itemData['nome'], $itemData['valor']);
                    $venda->adicionarItem($produto, $itemData['qtd']);
                }
                return $venda;
            }
        }
        return null;
    }

    public function remover($dataHora) {
        $dados = $this->carregarDados();
        $dados = array_filter($dados, function($vendaData) use ($dataHora) {
            return $vendaData['dataHora'] != $dataHora;
        });
        $this->salvarDados($dados);
    }

    public function __toString() {
        $dados = $this->carregarDados();
        $result = "";
        foreach ($dados as $vendaData) {
            $result .= sprintf("Data-Hora: %s\n", $vendaData['dataHora']);
            foreach ($vendaData['itens'] as $itemData) {
                $result .= sprintf("  Produto: %s\n  Qtd: %d\n  Valor: %.2f\n\n", $itemData['nome'], $itemData['qtd'], $itemData['valor']);
            }
            $result .= "\n";
        }
        return $result;
    }
}

?>