<?php

require_once 'MenuAbstrato.php';
require_once '../app/controllers/MenuProdutoController.php';
require_once '../app/controllers/MenuVendaController.php';

class MenuPrincipal extends MenuAbstrato {
    private $menuProduto;
    private $menuVenda;

    public function __construct() {
        $this->menuProduto = new MenuProdutoController();
        $this->menuVenda = new MenuVendaController();
    }

    public function processarOpcao($opcao) {
        $this->executarOpcao($opcao);
    }

    protected function executarOpcao($opcao) {
        switch ($opcao) {
            case 0:
                echo "Programa encerrado.";
                break;

            case 1:
                $this->menuProduto->mostrarMenu();
                break;

            case 2:
                $this->menuVenda->mostrarMenu();
                break;

            default:
                echo "OPCAO INVALIDA\n";
        }
    }

    protected function mostrarOpcoes() {
        echo "0 -> FECHAR PROGRAMA<br>";
        echo "1 -> PRODUTO<br>";
        echo "2 -> VENDA<br>";
    }

    protected function mostrarTitulo() {
        echo "<h1>MENU PRINCIPAL</h1>";
    }

    protected function getMenuName() {
        return 'principal';
    }
}

?>