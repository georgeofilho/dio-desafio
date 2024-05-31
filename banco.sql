-- Criação do Banco de Dados
CREATE DATABASE mercado;
USE mercado;

-- Criação da Tabela de Usuários
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);

-- Criação da Tabela de Mercadorias
CREATE TABLE mercadorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10, 2) NOT NULL,
    quantidade_estoque INT NOT NULL DEFAULT 0,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    data_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Criação da Tabela de Log de Operações
CREATE TABLE log_operacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    mercadoria_id INT,
    operacao VARCHAR(50) NOT NULL,
    data_operacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    quantidade INT,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (mercadoria_id) REFERENCES mercadorias(id)
);

-- Exemplo de Procedimentos Armazenados
DELIMITER //

CREATE PROCEDURE inserir_mercadoria (
    IN p_nome VARCHAR(100),
    IN p_descricao TEXT,
    IN p_preco DECIMAL(10, 2),
    IN p_quantidade_estoque INT,
    IN p_usuario_id INT
)
BEGIN
    INSERT INTO mercadorias (nome, descricao, preco, quantidade_estoque) 
    VALUES (p_nome, p_descricao, p_preco, p_quantidade_estoque);
    
    DECLARE last_id INT;
    SET last_id = LAST_INSERT_ID();
    
    INSERT INTO log_operacoes (usuario_id, mercadoria_id, operacao, quantidade)
    VALUES (p_usuario_id, last_id, 'insercao', p_quantidade_estoque);
END //

DELIMITER ;

-- Atualizar Mercadoria
DELIMITER //

CREATE PROCEDURE atualizar_mercadoria (
    IN p_id INT,
    IN p_nome VARCHAR(100),
    IN p_descricao TEXT,
    IN p_preco DECIMAL(10, 2),
    IN p_quantidade_estoque INT,
    IN p_usuario_id INT
)
BEGIN
    UPDATE mercadorias 
    SET nome = p_nome, descricao = p_descricao, preco = p_preco, quantidade_estoque = p_quantidade_estoque 
    WHERE id = p_id;
    
    INSERT INTO log_operacoes (usuario_id, mercadoria_id, operacao, quantidade)
    VALUES (p_usuario_id, p_id, 'atualizacao', p_quantidade_estoque);
END //

DELIMITER ;

-- Excluir Mercadoria
DELIMITER //

CREATE PROCEDURE excluir_mercadoria (
    IN p_id INT,
    IN p_usuario_id INT
)
BEGIN
    DELETE FROM mercadorias WHERE id = p_id;
    
    INSERT INTO log_operacoes (usuario_id, mercadoria_id, operacao)
    VALUES (p_usuario_id, p_id, 'exclusao');
END //

DELIMITER ;

-- Inserção de Dados e Testes
-- Inserir um usuário
INSERT INTO usuarios (nome, email, senha) VALUES ('Admin', 'admin@example.com', 'senha123');

-- Inserir uma mercadoria
CALL inserir_mercadoria('Arroz', 'Arroz branco 5kg', 15.50, 100, 1);

-- Atualizar uma mercadoria
CALL atualizar_mercadoria(1, 'Arroz', 'Arroz integral 5kg', 18.00, 150, 1);

-- Excluir uma mercadoria
CALL excluir_mercadoria(1, 1);
