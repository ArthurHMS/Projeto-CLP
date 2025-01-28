<?php

require_once __DIR__ . '/../data/DAOVenda.php';
require_once __DIR__ . '/../data/DAOProduto.php';
require_once __DIR__ . '/../models/Venda.php';
require_once __DIR__ . '/../models/Produto.php';

class MenuVendaController {
    private $daoVenda;
    private $daoProduto;

    public function __construct() {
        $this->daoVenda = DAOVenda::getInstance();
        $this->daoProduto = DAOProduto::getInstance();
    }

    public function processarOpcao($opcao) {
        $this->executarOpcao($opcao);
    }

    public function mostrarTitulo() {
        echo "MENU VENDAS\n";
    }

    public function listar() {
        echo $this->daoVenda->__toString();
    }

    public function adicionar($scanner) {
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
            echo "<input type='text' name='produtoNome' id='produtoNome' required><br>";
            echo "<label for='qtd'>Quantidade: </label>";
            echo "<input type='number' name='qtd' id='qtd' required><br>";
            echo "<button type='submit'>Adicionar</button>";
            echo "</form>";
        }
    }

    public function remover($scanner) {
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
            echo "<input type='number' name='id' id='id' required><br>";
            echo "<button type='submit'>Remover</button>";
            echo "</form>";
        }
    }

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

    public function mostrarOpcoes() {
        echo "0 -> VOLTAR<br>";
        echo "1 -> LISTAR<br>";
        echo "2 -> ADICIONAR<br>";
        echo "3 -> REMOVER<br>";
    }

    private function executarOpcao($opcao) {
        switch ($opcao) {
            case 0:
                return 0;

            case 1:
                $this->listar();
                break;

            case 2:
                $this->adicionar(null);
                break;

            case 3:
                $this->remover(null);
                break;

            default:
                echo "OPCAO INVALIDA\n";
        }

        return 1;
    }

    public function getMenuName() {
        return 'venda';
    }
}

?>