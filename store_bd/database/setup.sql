-- ============================================================
--  store_bd  |  Full Setup Script
--  Import this in phpMyAdmin
-- ============================================================

-- STEP 1: Fresh database
DROP DATABASE IF EXISTS store_bd;
CREATE DATABASE store_bd CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE store_bd;

-- ============================================================
-- STEP 2: Tables
-- ============================================================

CREATE TABLE manufacturer (
    id      INT          NOT NULL AUTO_INCREMENT,
    name    VARCHAR(120) NOT NULL,
    country VARCHAR(80)  NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE product (
    id              INT            NOT NULL AUTO_INCREMENT,
    manufacturer_id INT            NOT NULL,
    product_name    VARCHAR(150)   NOT NULL,
    model           VARCHAR(100)   NOT NULL,
    price           DECIMAL(10,2)  NOT NULL,
    description     TEXT,
    PRIMARY KEY (id),
    CONSTRAINT fk_product_manufacturer
        FOREIGN KEY (manufacturer_id)
        REFERENCES manufacturer (id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ============================================================
-- STEP 3: Views
-- ============================================================

CREATE VIEW store_product_view AS
    SELECT
        p.id,
        p.product_name,
        p.model,
        p.price,
        p.description,
        m.name    AS manufacturer_name,
        m.country AS manufacturer_country
    FROM product p
    JOIN manufacturer m ON p.manufacturer_id = m.id;

CREATE VIEW store_manufacturer_view AS
    SELECT id, name, country
    FROM manufacturer;

-- ============================================================
-- STEP 4: Stored Procedures
-- ============================================================

DROP PROCEDURE IF EXISTS store_insert_manufacturer;
DELIMITER $$
CREATE PROCEDURE store_insert_manufacturer(
    IN p_name    VARCHAR(120),
    IN p_country VARCHAR(80)
)
BEGIN
    INSERT INTO manufacturer (name, country) VALUES (p_name, p_country);
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS store_insert_product;
DELIMITER $$
CREATE PROCEDURE store_insert_product(
    IN p_manufacturer_id INT,
    IN p_product_name    VARCHAR(150),
    IN p_model           VARCHAR(100),
    IN p_price           DECIMAL(10,2),
    IN p_description     TEXT
)
BEGIN
    INSERT INTO product (manufacturer_id, product_name, model, price, description)
    VALUES (p_manufacturer_id, p_product_name, p_model, p_price, p_description);
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS store_delete_manufacturer;
DELIMITER $$
CREATE PROCEDURE store_delete_manufacturer(IN p_id INT)
BEGIN
    DELETE FROM manufacturer WHERE id = p_id;
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS store_get_all_products;
DELIMITER $$
CREATE PROCEDURE store_get_all_products()
BEGIN
    SELECT * FROM store_product_view ORDER BY id DESC;
END$$
DELIMITER ;

-- ============================================================
-- STEP 5: Sample Seed Data
-- ============================================================

INSERT INTO manufacturer (name, country) VALUES
    ('Samsung',  'South Korea'),
    ('Apple',    'United States'),
    ('Walton',   'Bangladesh');

INSERT INTO product (manufacturer_id, product_name, model, price, description) VALUES
    (1, 'Galaxy S24',     'SM-S9210',  89999.00, 'Flagship Android smartphone with AI features.'),
    (2, 'iPhone 15 Pro',  'A3104',    149999.00, 'Apple titanium-body pro smartphone.'),
    (3, 'Walton Primo X6','PX6',       15990.00, 'Affordable 4G Android phone made in Bangladesh.');
