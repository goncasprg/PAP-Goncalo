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
    first_name VARCHAR(50) NOT NULL,   -- Nome
    last_name VARCHAR(50) NOT NULL,    -- Sobrenome
    email VARCHAR(100) NOT NULL UNIQUE,-- Email
    password VARCHAR(255) NOT NULL,    -- Palavra-passe (hash, por questões de segurança)
    phone VARCHAR(15),                 -- Telefone
    role ENUM('admin', 'client') DEFAULT 'client', -- Papel do utilizador no sistema
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

INSERT INTO cars (brand, model, registration_year, mileage, seats, fuel_type, power, engine_capacity, transmission, color, warranty, price, description)
VALUES
('Audi', 'A3 1.6 TDI Sport', 2018, 120000, 5, 'Diesel', 110, 1.6, 'Manual', 'Preto', 12, 28600.00, 'Carro desportivo compacto, excelente para cidade e estrada.'),
('BMW', 'Série 3 2.0d M Sport', 2020, 90000, 5, 'Diesel', 190, 2.0, 'Automática', 'Azul', 24, 45800.00, 'Sedan premium com alto desempenho e conforto.'),
('Mercedes', 'Classe C 2.2 CDI Elegance', 2017, 110000, 5, 'Diesel', 170, 2.2, 'Automática', 'Cinza', 18, 36300.00, 'Luxuoso e confortável, ideal para viagens longas.'),
('Nissan', 'Qashqai 1.5 dCi Tekna', 2021, 30000, 5, 'Diesel', 115, 1.5, 'Manual', 'Branco', 36, 38500.00, 'SUV moderno com tecnologia avançada e baixo consumo.'),
('Volkswagen', 'Golf 1.4 TSI Highline', 2019, 80000, 5, 'Gasolina', 150, 1.4, 'Automática', 'Vermelho', 24, 18900.00, 'Compacto esportivo com excelente desempenho e economia.');

INSERT INTO car_images (car_id, image_url)
VALUES
(1, 'assets/images/carros/Audi_A3.jpg'),
(2, 'assets/images/carros/BMW_Serie3.jpg'),
(3, 'assets/images/carros/Mercedes_ClasseC.jpg'),
(4, 'assets/images/carros/Nissan_Qashqai.jpg'),
(5, 'assets/images/carros/VW_Golf.jpg');

ALTER TABLE users MODIFY last_name VARCHAR(50) DEFAULT NULL;


CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    car_id INT NOT NULL,
    user_name VARCHAR(100) NOT NULL,
    rating INT CHECK (rating BETWEEN 1 AND 5),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (car_id) REFERENCES cars(id) ON DELETE CASCADE
);
