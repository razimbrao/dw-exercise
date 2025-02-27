<?php

use Php\Dw\Connect;

function createFactSales(): void
{
    $pdo = Connect::getInstance();
    $pdo->exec("DELETE FROM sales");
    $stmt = $pdo->query("SELECT * from staging_area");
    $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    $sql = "INSERT INTO sales (product_id, client_id, order_date_id, total_amount) VALUES (:product_id, :client_id, :order_date_id, :total_amount)";
    foreach($rows as $row) {
        $insert = [];
        $insert[":product_id"] = getProductId($row["produto"]);
        $insert[":client_id"] = getClientId($row["cliente"]);
        $insert[":order_date_id"] = getOrderDateId($row["data_pedido"]);
        $insert[":total_amount"] = $row["valor_total"];
        $pdo->prepare($sql)->execute($insert);
    }
}

function getProductId(string $productName): int
{
    $pdo = Connect::getInstance();
    $stmt = $pdo->prepare("SELECT id FROM products WHERE product = :product");
    $stmt->execute([":product" => $productName]);
    $id = $stmt->fetchColumn();
    return $id;
}

function getClientId(string $clientName): int
{
    $pdo = Connect::getInstance();
    $stmt = $pdo->prepare("SELECT id FROM clients WHERE client = :client");
    $stmt->execute([":client" => $clientName]);
    $id = $stmt->fetchColumn();
    return $id;
}

function getOrderDateId(string $orderDate): int
{
    $pdo = Connect::getInstance();
    $stmt = $pdo->prepare("SELECT id FROM order_dates WHERE order_date = :order_date");
    $stmt->execute([":order_date" => $orderDate]);
    $id = $stmt->fetchColumn();
    return $id;
}