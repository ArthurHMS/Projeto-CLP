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
        return sprintf("Produto: %s\nValor: %.2f\nQuantidade: %d\nSubtotal: %.2f\n", $this->produto->getNome(), $this->valor, $this->qtd, $this->valor * $this->qtd);
    }
}

?>