CREATE UNLOGGED TABLE clientes (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    limite BIGINT NOT NULL,
    saldo BIGINT NOT NULL
);

INSERT INTO clientes (nome, limite, saldo) VALUES
    ('o barato sai caro', 100000, 0),
    ('zan corp ltda', 80000, 0),
    ('les cruders', 1000000, 0),
    ('padaria joia de cocaia', 10000000, 0),
    ('kid mais', 500000, 0);

CREATE UNLOGGED TABLE transacoes (
    id SERIAL PRIMARY KEY,
    cliente_id INT NOT NULL, 
    tipo CHAR(1) NOT NULL,
    realizada_em TIMESTAMP NOT NULL,

    CONSTRAINT fk_cliente_id
        FOREIGN KEY (cliente_id) REFERENCES clientes(id)
        ON DELETE CASCADE
);