<?php

use Php\Dw\Connect;

function createOrderDateDimension(array $rows): void
{
    $orderDates = [];
    foreach($rows as $row) {
        $orderDate = $row["data_pedido"];
        if(array_key_exists($orderDate, $orderDates)) {
            continue;
        }
        $orderDates[$row["data_pedido"]] = 1;
    }

    $pdo = Connect::getInstance();

    $sql = "INSERT INTO order_dates (order_date) VALUES (:order_date)";

    foreach($orderDates as $orderDate => $value) {
        $pdo->prepare($sql)->execute([":order_date" => $orderDate]);
    }
}
