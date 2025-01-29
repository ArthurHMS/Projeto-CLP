<?php

require_once 'MenuAbstrato.php';

abstract class MenuEntidade extends MenuAbstrato {

    protected abstract function listar();

    protected abstract function adicionar();

    protected abstract function remover();

    protected function executarOpcao($opcao) {
        switch ($opcao) {
            case 0:
                return 0;

            case 1:
                $this->listar();
                break;

            case 2:
                $this->adicionar();
                break;

            case 3:
                $this->remover();
                break;

            default:
                echo "OPCAO INVALIDA\n";
        }

        return 1;
    }

    protected function mostrarOpcoes() {
        echo "0 -> VOLTAR<br>";
        echo "1 -> LISTAR<br>";
        echo "2 -> ADICIONAR<br>";
        echo "3 -> REMOVER<br>";
    }
}

?>