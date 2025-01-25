<?php

require_once '../app/models/Entidade.php';
require_once '../app/models/Totalizavel.php';

class Produto extends Entidade implements Totalizavel {
    private $nome;
    private $valor;

    public function __construct($nome = "", $valor = 0.0) {
        parent::__construct();
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
        return sprintf("%sNome: %s\tValor: %.2f", parent::__toString(), $this->nome, $this->valor);
    }
}

?>