CREATE DATABASE car_choice;
USE car_choice;
CREATE TABLE cars (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Identificador único do carro
    brand VARCHAR(50) NOT NULL,        -- Marca
    model VARCHAR(50) NOT NULL,        -- Modelo
    registration_year YEAR NOT NULL,   -- Ano de registo
    mileage INT NOT NULL,              -- Quilómetros
    seats INT NOT NULL,                -- Lugares
    fuel_type ENUM('Gasolina', 'Diesel', 'Elétrico', 'Híbrido', 'GPL') NOT NULL, -- Tipo de combustível
    power INT NOT NULL,                -- Cavalagem/Potência (em CV)
    engine_capacity FLOAT NOT NULL,    -- Cilindrada (em litros, ex.: 1.5)
    transmission ENUM('Manual', 'Automática', 'Semi-Automática') NOT NULL, -- Transmissão
    color VARCHAR(20) NOT NULL,        -- Cor
    warranty INT DEFAULT 0,            -- Garantia (em meses, 0 para nenhum)
    price DECIMAL(10, 2) NOT NULL,     -- Preço do carro
    description TEXT,                  -- Descrição adicional
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Data de criação do registo
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Identificador único do utilizador
    first_name VARCHAR(50) NOT NULL,  -- Nome
    last_name VARCHAR(50) NOT NULL,   -- Sobrenome
    email VARCHAR(100) NOT NULL UNIQUE, -- Email (deve ser único)
    password VARCHAR(255) NOT NULL,   -- Palavra-passe (hash, por questões de segurança)
    phone VARCHAR(15),                -- Telefone
    role ENUM('Admin', 'Client') DEFAULT 'Cliente', -- Papel do utilizador no sistema
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Data de criação do registo
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP -- Última atualização
);

CREATE TABLE sales (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Identificador único da venda
    car_id INT NOT NULL,               -- Relacionado ao carro vendido
    user_id INT NOT NULL,              -- Relacionado ao cliente que comprou
    sale_price DECIMAL(10, 2) NOT NULL,-- Preço da venda
    sale_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Data da venda
    FOREIGN KEY (car_id) REFERENCES cars(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE rentals (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Identificador único do aluguer
    car_id INT NOT NULL,               -- Relacionado ao carro alugado
    user_id INT NOT NULL,              -- Relacionado ao cliente que alugou
    rental_start_date DATE NOT NULL,   -- Data de início do aluguer
    rental_end_date DATE NOT NULL,     -- Data de término do aluguer
    daily_rate DECIMAL(10, 2) NOT NULL,-- Taxa diária do aluguer
    total_price DECIMAL(10, 2) NOT NULL, -- Preço total calculado
    FOREIGN KEY (car_id) REFERENCES cars(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE car_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    car_id INT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    FOREIGN KEY (car_id) REFERENCES cars(id)
);
CREATE TABLE car_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);
