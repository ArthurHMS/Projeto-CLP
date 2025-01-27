<?php

require_once 'DAO.php';
require_once '../models/Produto.php';
require_once '../../config/database.php';

class DAOProduto {
    private static $instance;
    private $filePath;

    private function __construct() {
        $this->filePath = __DIR__ . '/produtos.json';
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new DAOProduto();
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

    public function adicionar($produto) {
        $dados = $this->carregarDados();
        $dados[] = [
            'id' => $produto->getId(),
            'nome' => $produto->getNome(),
            'valor' => $produto->getValor()
        ];
        $this->salvarDados($dados);
    }

    public function buscar($id) {
        $dados = $this->carregarDados();
        foreach ($dados as $produto) {
            if ($produto['id'] == $id) {
                return new Produto($produto['nome'], $produto['valor']);
            }
        }
        return null;
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

    public function remover($id) {
        $dados = $this->carregarDados();
        $dados = array_filter($dados, function($produto) use ($id) {
            return $produto['id'] != $id;
        });
        $this->salvarDados($dados);
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
            $result .= sprintf("Id: %d\tNome: %s\tValor: %.2f\n", $produto['id'], $produto['nome'], $produto['valor']);
        }
        return $result;
    }
}

?>