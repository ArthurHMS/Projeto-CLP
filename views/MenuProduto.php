<?php

require_once 'MenuEntidade.php';
require_once '../app/controllers/MenuProdutoController.php';

class MenuProduto extends MenuEntidade {
    private $controller;

    public function __construct() {
        $this->controller = new MenuProdutoController();
    }

    public function processarOpcao($opcao) {
        $this->controller->processarOpcao($opcao);
    }

    protected function mostrarTitulo() {
        $this->controller->mostrarTitulo();
    }

    protected function listar() {
        $this->controller->listar();
    }

    protected function adicionar() {
        $this->controller->adicionar();
    }

    protected function remover() {
        $this->controller->remover();
    }

    protected function mostrarOpcoes() {
        $this->controller->mostrarOpcoes();
    }

    protected function getMenuName() {
        return 'produto';
    }
}

?>