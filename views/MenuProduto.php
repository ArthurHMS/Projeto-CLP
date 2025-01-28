<?php

require_once 'MenuEntidade.php';
require_once '../app/data/DAOProduto.php';
require_once '../app/models/Produto.php';

class MenuProduto extends MenuEntidade {
    private $dao;

    public function __construct() {
        $this->dao = DAOProduto::getInstance();
    }

    public function processarOpcao($opcao) {
        $this->executarOpcao($opcao);
    }

    protected function mostrarTitulo() {
        echo "<h1>MENU PRODUTOS</h1>";
    }

    protected function listar() {
        echo nl2br($this->dao->__toString());
    }

    protected function adicionar($scanner) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = isset($_POST['nome']) ? trim($_POST['nome']) : null;
            $valor = isset($_POST['valor']) ? floatval($_POST['valor']) : null;

            if ($nome == null || $nome === "" || $valor === null || $valor <= 0.0) {
                echo "<p>Favor informar os dados corretamente.</p>";
            } else {
                $this->dao->adicionar(new Produto($nome, $valor));
                echo "<p>Produto adicionado com sucesso!</p>";
            }
        } else {
            echo "<form method='POST'>";
            echo "<input type='hidden' name='menu' value='produto'>";
            echo "<label for='nome'>Nome: </label>";
            echo "<input type='text' name='nome' id='nome'><br>";
            echo "<label for='valor'>Valor: </label>";
            echo "<input type='number' step='0.01' name='valor' id='valor'><br>";
            echo "<button type='submit'>Adicionar</button>";
            echo "</form>";
        }
    }

    protected function remover($scanner) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = isset($_POST['nome']) ? trim($_POST['nome']) : null;

            if ($nome == null || $nome === "") {
                echo "<p>Favor informar o nome corretamente.</p>";
            } else {
                $this->dao->removerPorNome($nome);
                echo "<p>Produto removido com sucesso!</p>";
            }
        } else {
            echo "<form method='POST'>";
            echo "<input type='hidden' name='menu' value='produto'>";
            echo "<label for='nome'>Nome: </label>";
            echo "<input type='text' name='nome' id='nome'><br>";
            echo "<button type='submit'>Remover</button>";
            echo "</form>";
        }
    }

    protected function mostrarOpcoes() {
        echo "0 -> VOLTAR<br>";
        echo "1 -> LISTAR PRODUTOS<br>";
        echo "2 -> ADICIONAR PRODUTO<br>";
        echo "3 -> REMOVER PRODUTO<br>";
    }

    protected function getMenuName() {
        return 'produto';
    }
}

?>