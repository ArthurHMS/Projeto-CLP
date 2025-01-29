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
        echo "MENU VENDAS<br>\n";
    }

    public function listar() {
        echo nl2br($this->daoVenda->__toString());
    }

    public function adicionar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['menu']) && $_POST['menu'] === 'venda' && isset($_POST['opcao']) && $_POST['opcao'] == 2 && !isset($_POST['produtoNome']) && !isset($_POST['qtd'])) {
            // Exibe o formulário de adição de venda
            echo "<form method='POST'>";
            echo "<input type='hidden' name='menu' value='venda'>";
            echo "<input type='hidden' name='opcao' value='2'>";
            echo "<label for='produtoNome'>Nome do Produto: </label>";
            echo "<input type='text' name='produtoNome' id='produtoNome' required><br>";
            echo "<label for='qtd'>Quantidade: </label>";
            echo "<input type='number' name='qtd' id='qtd' required><br>";
            echo "<button type='submit'>Adicionar</button>";
            echo "</form>";
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['produtoNome']) && isset($_POST['qtd'])) {
            
            // Processa os dados do formulário de adição de venda
            $produtoNome = trim($_POST['produtoNome']);
            $qtd = intval($_POST['qtd']);
            $produto = $this->daoProduto->buscarPorNome($produtoNome);

            if ($produto == null || $qtd <= 0) {
                echo "<p>Favor informar os dados corretamente.</p>";
            } else {
                $venda = new Venda();
                $venda->adicionarItem($produto, $qtd);
                $this->daoVenda->adicionar($venda);
                echo "<p>Venda adicionada com sucesso!</p>";
                $this->mostrarMenu(); // Redireciona de volta ao menu de vendas
            }
        } else {
            // Exibe o menu de opções
            $this->mostrarMenu();
        }
    }

    public function remover() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['menu']) && $_POST['menu'] === 'venda' && isset($_POST['opcao']) && $_POST['opcao'] == 3 && !isset($_POST['dataHora'])) {
            // Exibe o formulário de remoção de venda
            echo "<form method='POST'>";
            echo "<input type='hidden' name='menu' value='venda'>";
            echo "<input type='hidden' name='opcao' value='3'>";
            echo "<label for='dataHora'>Data e Hora: </label>";
            echo "<input type='text' name='dataHora' id='dataHora' required><br>";
            echo "<button type='submit'>Remover</button>";
            echo "</form>";
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dataHora'])) {
            // Processa os dados do formulário de remoção de venda
            $dataHora = trim($_POST['dataHora']);

            if ($dataHora === "") {
                echo "<p>Favor informar a data e hora corretamente.</p>";
            } else {
                $this->daoVenda->remover($dataHora);
                echo "<p>Venda removida com sucesso!</p>";
                $this->mostrarMenu(); // Redireciona de volta ao menu de vendas
            }
        } else {
            // Exibe o menu de opções
            $this->mostrarMenu();
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

    protected function getMenuName() {
        return 'venda';
    }
}

?>