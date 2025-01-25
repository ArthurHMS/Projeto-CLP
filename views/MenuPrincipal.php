<?php

require_once '../views/MenuAbstrato.php';
require_once '../app/controllers/MenuProdutoController.php';
require_once '../app/controllers/MenuVendaController.php';

class MenuPrincipal extends MenuAbstrato {
    private $menuProduto;
    private $menuVenda;

    public function __construct() {
        parent::__construct();
        $this->menuProduto = new MenuProdutoController();
        $this->menuVenda = new MenuVendaController();
    }

    protected function executarOpcao($opcao, $scanner) {
        switch ($opcao) {
            case 0:
                return 0;

            case 1:
                $this->menuProduto->mostrarMenu($scanner);
                break;

            case 2:
                $this->menuVenda->mostrarMenu($scanner);
                break;

            default:
                echo "OPCAO INVALIDA\n";
        }

        return 1;
    }

    protected function mostrarOpcoes() {
        echo "0 -> FECHAR PROGRAMA\n";
        echo "1 -> PRODUTO\n";
        echo "2 -> VENDA\n";
    }

    protected function mostrarTitulo() {
        echo "MENU PRINCIPAL\n";
    }
}

?>