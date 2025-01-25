<?php

require_once '../app/models/Entidade.php';
require_once '../app/models/Totalizavel.php';
require_once '../app/models/Produto.php';
require_once '../app/models/ItemVenda.php';

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
        $sb = sprintf("%sData-Hora: %s\nItens:\n", parent::__toString(), $this->dataHora->format('Y-m-d H:i:s'));

        foreach ($this->itens as $item) {
            $sb .= "\n  " . $item->__toString();
        }

        $sb .= "\nTOTAL: " . $this->total();

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