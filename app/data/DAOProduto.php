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
            'nome' => $produto->getNome(),
            'valor' => $produto->getValor()
        ];
        $this->salvarDados($dados);
    }

    public function buscarPorNome($nome) {
        $dados = $this->carregarDados();
        foreach ($dados as $produto) {
            if ($produto['nome'] == $nome) {
                return new Produto($produto['nome'], $produto['valor']);
            }
        }
        return null;
    }

    public function removerPorNome($nome) {
        $dados = $this->carregarDados();
        $dados = array_filter($dados, function($produto) use ($nome) {
            return $produto['nome'] != $nome;
        });
        $this->salvarDados($dados);
    }

    public function __toString() {
        $dados = $this->carregarDados();
        $result = "";
        foreach ($dados as $produto) {
            $result .= sprintf("Nome: %s\nValor: %.2f\n\n", $produto['nome'], $produto['valor']);
        }
        return $result;
    }
}

?>