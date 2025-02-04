<?php

require_once 'DAO.php';
require_once __DIR__ . '/../models/Produto.php';

class DAOProduto {
    private static $instance;
    private $filePath;

    private function __construct() {
        $this->filePath = __DIR__ . '/produtos.json';
        if (!file_exists($this->filePath)) {
            file_put_contents($this->filePath, json_encode([]));
        }
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new DAOProduto();
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

    public function adicionar($produto) {
        $dados = $this->carregarDados();
        $dados[] = [
            'id' => $produto->getId(),
            'nome' => $produto->getNome(),
            'valor' => $produto->getValor()
        ];
        $this->salvarDados($dados);
    }

    public function buscarPorId($id) {
        $dados = $this->carregarDados();
        foreach ($dados as $produto) {
            if ($produto['id'] == $id) {
                return new Produto($produto['nome'], $produto['valor']);
            }
        }
        return null;
    }

    public function removerPorId($id) {
        $dados = $this->carregarDados();
        $dados = array_filter($dados, function($produto) use ($id) {
            return $produto['id'] != $id;
        });
        $this->salvarDados($dados);
    }

    public function __toString() {
        $dados = $this->carregarDados();
        $result = "";
        foreach ($dados as $produto) {
            $result .= sprintf("Id: %d\nNome: %s\nValor: %.2f\n\n", $produto['id'], $produto['nome'], $produto['valor']);
        }
        return $result;
    }
}

?>