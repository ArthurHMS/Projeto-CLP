<?php

abstract class MenuAbstrato {

    public function mostrarMenu($scanner) {
        $opcao = 0;

        do {
            echo "\n\n\n";

            $this->mostrarTitulo();

            $this->mostrarOpcoes();

            echo "INFORME A SUA OPCAO: ";
            $opcao = intval(trim(fgets($scanner)));

            $opcao = $this->executarOpcao($opcao, $scanner);

        } while ($opcao != 0);
    }

    protected abstract function executarOpcao($opcao, $scanner);

    protected abstract function mostrarOpcoes();

    protected abstract function mostrarTitulo();
}

?>