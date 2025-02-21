<?php

require_once 'MenuEntidade.php';
require_once '../app/controllers/MenuVendaController.php';

class MenuVenda extends MenuEntidade {
    private $controller;

    public function __construct() {
        $this->controller = new MenuVendaController();
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
        return 'venda';
    }
}

?>