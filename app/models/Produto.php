<?php

class Produto {
    private $nome;
    private $valor;

    public function __construct($nome = "", $valor = 0.0) {
        $this->nome = $nome;
        $this->valor = $valor;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getValor() {
        return $this->valor;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setValor($valor) {
        $this->valor = $valor;
    }

    public function total() {
        return $this->valor;
    }

    public function __toString() {
        return sprintf("Nome: %s\nValor: %.2f\n", $this->nome, $this->valor);
    }
}

?>