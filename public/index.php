<?php

require_once '../views/MenuPrincipal.php';
require_once '../views/MenuProduto.php';
require_once '../views/MenuVenda.php';

$menuPrincipal = new MenuPrincipal();
$menuProduto = new MenuProduto();
$menuVenda = new MenuVenda();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['menu']) && isset($_POST['opcao'])) {
        $menu = $_POST['menu'];
        $opcao = intval($_POST['opcao']);

        switch ($menu) {
            case 'principal':
                $menuPrincipal->processarOpcao($opcao);
                break;
            case 'produto':
                $menuProduto->processarOpcao($opcao);
                break;
            case 'venda':
                $menuVenda->processarOpcao($opcao);
                break;
            default:
                echo "Menu inválido.";
        }
    } else {
        echo "Dados do formulário incompletos.";
    }
} else {
    $menuPrincipal->mostrarMenu();
}

?>