<?php

require_once '../views/MenuEntidade.php';
require_once '../app/data/DAOProduto.php';
require_once '../app/models/Produto.php';

class MenuProdutoController extends MenuEntidade {
    private $dao;

    public function __construct() {
        parent::__construct();
        $this->dao = DAOProduto::getInstance();
    }

    protected function mostrarTitulo() {
        echo "MENU PRODUTOS\n";
    }

    protected function listar() {
        echo $this->dao->__toString();
    }

    protected function adicionar($scanner) {
        $nome = null;
        $valor = 0.0;

        while (true) {
            try {
                echo "\nDigite o nome: ";
                $nome = trim(fgets($scanner));

                echo "Digite o valor: ";
                $valor = floatval(trim(fgets($scanner)));

                if ($nome == null || $nome === "" || $valor <= 0.0) {
                    throw new Exception("\nFavor informar os dados corretamente.\n");
                } else {
                    break;
                }
            } catch (Exception $ex) {
                echo $ex->getMessage();
            }
        }

        $this->dao->adicionar(new Produto($nome, $valor));
    }

    protected function remover($scanner) {
        $nome = null;

        while (true) {
            try {
                echo "\nDigite o nome: ";
                $nome = trim(fgets($scanner));

                if ($nome == null || $nome === "") {
                    throw new Exception("\nFavor informar o nome corretamente.\n");
                } else {
                    break;
                }
            } catch (Exception $ex) {
                echo $ex->getMessage();
            }
        }

        $this->dao->removerPorNome($nome);
    }
}

?>