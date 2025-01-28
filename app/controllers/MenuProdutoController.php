<?php
require_once __DIR__ . '/../../views/MenuEntidade.php';
require_once __DIR__ . '/../data/DAOProduto.php';
require_once __DIR__ . '/../models/Produto.php';

class MenuProdutoController extends MenuEntidade {
    private $dao;

    public function __construct() {
        $this->dao = DAOProduto::getInstance();
    }

    public function processarOpcao($opcao) {
        $this->executarOpcao($opcao);
    }

    public function mostrarTitulo() {
        echo "MENU PRODUTOS\n";
    }

    public function listar() {
        echo $this->dao->__toString();
    }

    public function adicionar($scanner) {
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
            echo "<input type='text' name='nome' id='nome' required><br>";
            echo "<label for='valor'>Valor: </label>";
            echo "<input type='number' step='0.01' name='valor' id='valor' required><br>";
            echo "<button type='submit'>Adicionar</button>";
            echo "</form>";
        }
    }

    public function remover($scanner) {
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
            echo "<input type='text' name='nome' id='nome' required><br>";
            echo "<button type='submit'>Remover</button>";
            echo "</form>";
        }
    }

    protected function executarOpcao($opcao) {
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

    public function mostrarOpcoes() {
        echo "0 -> VOLTAR<br>";
        echo "1 -> LISTAR<br>";
        echo "2 -> ADICIONAR<br>";
        echo "3 -> REMOVER<br>";
    }

    protected function getMenuName() {
        return 'produto';
    }
}

?>