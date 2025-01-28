<?php

require_once 'MenuAbstrato.php';

abstract class MenuEntidade extends MenuAbstrato {

    protected abstract function listar();

    protected abstract function adicionar($scanner);

    protected abstract function remover($scanner);

    protected function executarOpcao($opcao) {
        switch ($opcao) {
            case 0:
                return 0;

            case 1:
                $this->listar();
                break;

            case 2:
                $this->adicionar(null);
                break;

            case 3:
                $this->remover(null);
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