<?php

abstract class MenuAbstrato {

    public function mostrarMenu() {
        echo "<form method='POST'>";
        $this->mostrarTitulo();
        $this->mostrarOpcoes();
        echo "<input type='hidden' name='menu' value='" . $this->getMenuName() . "'>";
        echo "<label for='opcao'>INFORME A SUA OPCAO: </label>";
        echo "<input type='number' name='opcao' id='opcao'>";
        echo "<button type='submit'>Enviar</button>";
        echo "</form>";
    }

    protected abstract function executarOpcao($opcao);

    protected abstract function mostrarOpcoes();

    protected abstract function mostrarTitulo();

    protected abstract function getMenuName();
}

?>