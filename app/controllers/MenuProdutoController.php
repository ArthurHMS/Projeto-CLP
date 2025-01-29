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
        echo "MENU PRODUTOS<br>\n";
    }

    public function listar() {
        echo nl2br($this->dao->__toString());
    }

    public function adicionar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['menu']) && $_POST['menu'] === 'produto' && isset($_POST['opcao']) && $_POST['opcao'] == 2 && !isset($_POST['nome']) && !isset($_POST['valor'])) {
            // Exibe o formulário de adição de produto
            echo "<form method='POST'>";
            echo "<input type='hidden' name='menu' value='produto'>";
            echo "<input type='hidden' name='opcao' value='2'>";
            echo "<label for='nome'>Nome: </label>";
            echo "<input type='text' name='nome' id='nome' required><br>";
            echo "<label for='valor'>Valor: </label>";
            echo "<input type='number' step='0.01' name='valor' id='valor' required><br>";
            echo "<button type='submit'>Adicionar</button>";
            echo "</form>";
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome']) && isset($_POST['valor'])) {
            
            // Processa os dados do formulário de adição de produto
            $nome = trim($_POST['nome']);
            $valor = floatval($_POST['valor']);

            if ($nome === "" || $valor <= 0.0) {
                echo "<p>Favor informar os dados corretamente.</p>";
            } else {
                $this->dao->adicionar(new Produto($nome, $valor));
                echo "<p>Produto adicionado com sucesso!</p>";
                $this->mostrarMenu(); // Redireciona de volta ao menu de produtos
            }
        } else {
            // Exibe o menu de opções
            $this->mostrarMenu();
        }
    }

    public function remover() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['menu']) && $_POST['menu'] === 'produto' && isset($_POST['opcao']) && $_POST['opcao'] == 3 && !isset($_POST['nome'])) {
            // Exibe o formulário de remoção de produto
            echo "<form method='POST'>";
            echo "<input type='hidden' name='menu' value='produto'>";
            echo "<input type='hidden' name='opcao' value='3'>";
            echo "<label for='nome'>Nome: </label>";
            echo "<input type='text' name='nome' id='nome' required><br>";
            echo "<button type='submit'>Remover</button>";
            echo "</form>";
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome'])) {
            // Processa os dados do formulário de remoção de produto
            $nome = trim($_POST['nome']);

            if ($nome === "") {
                echo "<p>Favor informar o nome corretamente.</p>";
            } else {
                $this->dao->removerPorNome($nome);
                echo "<p>Produto removido com sucesso!</p>";
                $this->mostrarMenu(); // Redireciona de volta ao menu de produtos
            }
        } else {
            // Exibe o menu de opções
            $this->mostrarMenu();
        }
    }

    public function executarOpcao($opcao) {
        switch ($opcao) {
            case 0:
                // Voltar ao menu principal
                $menuPrincipal = new MenuPrincipal();
                $menuPrincipal->mostrarMenu();
                break;

            case 1:
                $this->listar();
                break;

            case 2:
                $this->adicionar();
                break;

            case 3:
                $this->remover();
                break;

            default:
                echo "OPCAO INVALIDA\n";
        }
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