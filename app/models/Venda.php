<?php

require_once 'Totalizavel.php';
require_once 'Produto.php';
require_once 'ItemVenda.php';
require_once 'Entidade.php';

class Venda extends Entidade implements Totalizavel {
    private $dataHora;
    private $itens;

    public function __construct() {
        parent::__construct();
        $this->dataHora = new DateTime();
        $this->itens = [];
    }

    public function getDataHora() {
        return $this->dataHora;
    }

    public function setDataHora($dataHora) {
        $this->dataHora = $dataHora;
    }

    public function getItens() {
        return $this->itens;
    }

    public function adicionarItem($produto, $qtd) {
        $this->itens[] = new ItemVenda($produto, $qtd);
    }

    public function removerItemPorPosicao($posicao) {
        if (isset($this->itens[$posicao])) {
            unset($this->itens[$posicao]);
            $this->itens = array_values($this->itens); // Reindex array
        }
    }

    public function removerItemPorNome($nomeProduto) {
        $this->itens = array_values(array_filter($this->itens, function($item) use ($nomeProduto) {
            return strcasecmp($item->getProduto()->getNome(), $nomeProduto) !== 0;
        }));
    }

    public function __toString() {
        $sb = sprintf("Id: %d\nData-Hora: %s\nItens:\n", $this->id, $this->dataHora->format('Y-m-d H:i:s'));

        foreach ($this->itens as $item) {
            $sb .= "\n  " . $item->__toString() . "\n";
        }

        $sb .= "\nTOTAL: " . $this->total() . "\n";

        return $sb;
    }

    public function total() {
        $t = 0.0;

        foreach ($this->itens as $item) {
            $t += $item->getValor() * $item->getQtd();
        }

        return $t;
    }
}

?>