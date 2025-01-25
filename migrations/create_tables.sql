CREATE TABLE produtos (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    valor DECIMAL(10, 2) NOT NULL
);

CREATE TABLE vendas (
    id SERIAL PRIMARY KEY,
    data_hora DATETIME NOT NULL
);

CREATE TABLE itens_venda (
    id SERIAL PRIMARY KEY,
    venda_id INT NOT NULL,
    produto_id INT NOT NULL,
    qtd INT NOT NULL,
    valor DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (venda_id) REFERENCES vendas(id),
    FOREIGN KEY (produto_id) REFERENCES produtos(id)
);