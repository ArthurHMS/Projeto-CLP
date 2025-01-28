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
        $this->daoVenda = DAOVenda::getInstance();
        $this->daoProduto = DAOProduto::getInstance();
    }

    public function processarOpcao($opcao) {
        $this->executarOpcao($opcao);
    }

    protected function mostrarTitulo() {
        echo "<h1>MENU VENDAS</h1>";
    }

    protected function listar() {
        echo nl2br($this->daoVenda->__toString());
    }

    protected function adicionar($scanner) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $produtoNome = isset($_POST['produtoNome']) ? trim($_POST['produtoNome']) : null;
            $qtd = isset($_POST['qtd']) ? intval($_POST['qtd']) : null;
            $produto = $this->daoProduto->buscarPorNome($produtoNome);

            if ($produto == null || $qtd === null || $qtd <= 0) {
                echo "<p>Favor informar os dados corretamente.</p>";
            } else {
                $venda = new Venda();
                $venda->adicionarItem($produto, $qtd);
                $this->daoVenda->adicionar($venda);
                echo "<p>Venda adicionada com sucesso!</p>";
            }
        } else {
            echo "<form method='POST'>";
            echo "<input type='hidden' name='menu' value='venda'>";
            echo "<label for='produtoNome'>Nome do Produto: </label>";
            echo "<input type='text' name='produtoNome' id='produtoNome'><br>";
            echo "<label for='qtd'>Quantidade: </label>";
            echo "<input type='number' name='qtd' id='qtd'><br>";
            echo "<button type='submit'>Adicionar</button>";
            echo "</form>";
        }
    }

    protected function remover($scanner) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = isset($_POST['id']) ? intval($_POST['id']) : null;

            if ($id === null || $id <= 0) {
                echo "<p>Favor informar os dados corretamente.</p>";
            } else {
                $this->daoVenda->remover($id);
                echo "<p>Venda removida com sucesso!</p>";
            }
        } else {
            echo "<form method='POST'>";
            echo "<input type='hidden' name='menu' value='venda'>";
            echo "<label for='id'>ID: </label>";
            echo "<input type='number' name='id' id='id'><br>";
            echo "<button type='submit'>Remover</button>";
            echo "</form>";
        }
    }

    protected function mostrarOpcoes() {
        echo "0 -> VOLTAR<br>";
        echo "1 -> LISTAR VENDAS<br>";
        echo "2 -> ADICIONAR VENDA<br>";
        echo "3 -> REMOVER VENDA<br>";
    }

    protected function getMenuName() {
        return 'venda';
    }
}

?>