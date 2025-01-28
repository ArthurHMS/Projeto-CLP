<?php

require_once 'Entidade.php';

class Produto extends Entidade {
    protected $id;
    private $nome;
    private $valor;

    public function __construct($nome = "", $valor = 0.0) {
        parent::__construct();
        $this->nome = $nome;
        $this->valor = $valor;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
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