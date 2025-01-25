<?php

class ItemVenda {
    private $produto;
    private $qtd;
    private $valor;

    public function __construct($produto, $qtd) {
        $this->produto = $produto;
        $this->qtd = $qtd;
        $this->valor = $produto->getValor();
    }

    public function getProduto() {
        return $this->produto;
    }

    public function getQtd() {
        return $this->qtd;
    }

    public function getValor() {
        return $this->valor;
    }

    public function __toString() {
        return sprintf("%15s %8.2f x %5d = %8.2f", $this->produto->getNome(), $this->valor, $this->qtd, $this->valor * $this->qtd);
    }
}

?>