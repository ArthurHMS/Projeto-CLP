<?php

require_once 'MenuAbstrato.php';

abstract class MenuEntidade extends MenuAbstrato {

    protected abstract function listar();

    protected abstract function adicionar($scanner);

    protected abstract function remover($scanner);

    protected function executarOpcao($opcao, $scanner) {
        switch ($opcao) {
            case 0:
                return 0;

            case 1:
                $this->listar();
                break;

            case 2:
                $this->adicionar($scanner);
                break;

            case 3:
                $this->remover($scanner);
                break;

            default:
                echo "OPCAO INVALIDA\n";
        }

        return 1;
    }

    protected function mostrarOpcoes() {
        echo "0 -> VOLTAR\n";
        echo "1 -> LISTAR\n";
        echo "2 -> ADICIONAR\n";
        echo "3 -> REMOVER\n";
    }
}

?>