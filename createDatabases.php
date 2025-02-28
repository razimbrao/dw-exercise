<?php

use Php\Dw\Connect;

require_once __DIR__ . "/vendor/autoload.php";

$pdo = Connect::getInstance();

$pdo->exec("DROP TABLE IF EXISTS staging_area");
$pdo->exec("DROP TABLE IF EXISTS products");
$pdo->exec("DROP TABLE IF EXISTS clients");
$pdo->exec("DROP TABLE IF EXISTS order_dates");
$pdo->exec("DROP TABLE IF EXISTS order_days");
$pdo->exec("DROP TABLE IF EXISTS sales");
$pdo->exec("DROP TABLE IF EXISTS daily_sales");
$pdo->exec("DROP TABLE IF EXISTS agr_sales");

$sql = "CREATE TABLE IF NOT EXISTS staging_area (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    codigo_pedido VARCHAR(50),
    produto VARCHAR(255),
    quant INT,
    valor_uni DECIMAL(10,2),
    valor_total DECIMAL(10,2),
    cliente VARCHAR(255),
    entregue_por VARCHAR(255),
    data_pedido DATETIME,
    data_pagamento DATETIME,
    data_liberacao DATETIME NULL,
    data_envio DATETIME NULL,
    data_receb DATETIME NULL
);";

$pdo->exec($sql);

$sql = "CREATE TABLE IF NOT EXISTS products (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    product VARCHAR(255) UNIQUE
);";

$pdo->exec($sql);

$sql = "CREATE TABLE IF NOT EXISTS clients (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    client VARCHAR(255) UNIQUE
);";

$pdo->exec($sql);

$sql = "CREATE TABLE IF NOT EXISTS order_dates (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    order_date DATETIME UNIQUE
);";

$pdo->exec($sql);

$sql = "CREATE TABLE IF NOT EXISTS order_days (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    order_days DATETIME UNIQUE
);";

$pdo->exec($sql);

$sql = "CREATE TABLE IF NOT EXISTS sales (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    product_id INTEGER,
    client_id INTEGER,
    order_date_id INTEGER,
    total_amount INTEGER,
    FOREIGN KEY(product_id) REFERENCES products(id),
    FOREIGN KEY(client_id) REFERENCES clients(id),
    FOREIGN KEY(order_date_id) REFERENCES order_dates(id)
);";

$pdo->exec($sql);

$sql = "CREATE TABLE IF NOT EXISTS daily_sales (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    product_id INTEGER,
    client_id INTEGER,
    order_date_id INTEGER,
    total_amount INTEGER,
    FOREIGN KEY(product_id) REFERENCES products(id),
    FOREIGN KEY(client_id) REFERENCES clients(id),
    FOREIGN KEY(order_date_id) REFERENCES order_dates(id)
);";

$pdo->exec($sql);

$sql = "CREATE TABLE IF NOT EXISTS agr_sales (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    product_id INTEGER,
    client_id INTEGER,
    order_date_id INTEGER,
    release_date_id INTEGER,
    total_amount INTEGER,
    FOREIGN KEY(product_id) REFERENCES products(id),
    FOREIGN KEY(client_id) REFERENCES clients(id),
    FOREIGN KEY(order_date_id) REFERENCES order_dates(id)
    FOREIGN KEY(release_date_id) REFERENCES order_dates(id)
);";

$pdo->exec($sql);
