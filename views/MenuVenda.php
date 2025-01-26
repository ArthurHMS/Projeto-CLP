<?php

require_once 'MenuEntidade.php';
require_once '../app/data/DAOVenda.php';
require_once '../app/data/DAOProduto.php';
require_once '../app/models/Venda.php';
require_once '../app/models/Produto.php';

class MenuVenda extends MenuEntidade {
    private $daoVenda;
    private $daoProduto;

    public function __construct() {
        parent::__construct();
        $this->daoVenda = DAOVenda::getInstance();
        $this->daoProduto = DAOProduto::getInstance();
    }

    protected function mostrarTitulo() {
        echo "MENU VENDAS\n";
    }

    protected function listar() {
        echo $this->daoVenda->__toString();
    }

    protected function adicionar($scanner) {
        $venda = new Venda();
        $produto = null;
        $qtd = 0;

        while (true) {
            while (true) {
                try {
                    echo "\nDigite o nome do produto: ";
                    $produtoNome = trim(fgets($scanner));
                    $produto = $this->daoProduto->buscarPorNome($produtoNome);

                    echo "Digite a quantidade: ";
                    $qtd = intval(trim(fgets($scanner)));

                    if ($produto == null || $qtd <= 0) {
                        throw new Exception("\nFavor informar os dados corretamente.\n");
                    } else {
                        break;
                    }
                } catch (Exception $ex) {
                    echo $ex->getMessage();
                }
            }

            $venda->adicionarItem($produto, $qtd);

            echo "\nDeseja adicionar outro produto à venda (1-SIM/0-NAO)? ";
            if (intval(trim(fgets($scanner))) != 1) {
                break;
            }
        }

        echo "\n\nNOTA FISCAL\n" . $venda->__toString();
        $this->daoVenda->adicionar($venda);
    }

    protected function remover($scanner) {
        $id = 0;

        while (true) {
            try {
                echo "\nDigite o id: ";
                $id = intval(trim(fgets($scanner)));

                if ($id <= 0) {
                    throw new Exception("\nFavor informar os dados corretamente.\n");
                } else {
                    break;
                }
            } catch (Exception $ex) {
                echo $ex->getMessage();
            }
        }
        $this->daoVenda->remover($id);
    }
}

?>