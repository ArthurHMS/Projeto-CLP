<?php

class DAO {
    private $dados;

    public function __construct() {
        $this->dados = array();
    }

    public function getDados() {
        return $this->dados;
    }

    public function setDados($dados) {
        $this->dados = $dados;
    }

    public function adicionar($entidade) {
        $this->dados[] = $entidade;
    }

    public function buscar($id) {
        foreach ($this->dados as $entidade) {
            if ($entidade->getId() == $id) {
                return $entidade;
            }
        }
        return null;
    }

    public function remover($id) {
        $this->dados = array_filter($this->dados, function($entidade) use ($id) {
            return $entidade->getId() != $id;
        });
    }

    public function __toString() {
        $sb = "";
        foreach ($this->dados as $entidade) {
            $sb .= "\n" . $entidade->__toString();
        }
        return $sb;
    }
}

?>