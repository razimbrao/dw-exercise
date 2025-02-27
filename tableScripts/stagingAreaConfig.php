<?php

use Php\Dw\Connect;
use Php\Dw\Csv;

const STAGING_AREA_HEADER_TRANSLATION = [
    "Código Pedido" => "codigo_pedido",
    "Produto" => "produto",
    "Quant." => "quant",
    "Valor Uni" => "valor_uni",
    "Valor Total" => "valor_total",
    "Cliente" => "cliente",
    "Entregue por" => "entregue_por",
    "Data Pedido" => "data_pedido",
    "Data Pagamento" => "data_pagamento",
    "Data Liberação" => "data_liberacao",
    "Data Envio" => "data_envio",
    "Data Receb." => "data_receb"
];

$pdo = Connect::getInstance();

$pdo->exec("DELETE FROM staging_area");

function createStagingArea(Csv $csv) {
    foreach($csv->readCsv() as $row) {
        $insertRow = [];
        foreach($csv->header as $key => $header) {
            $databaseField = STAGING_AREA_HEADER_TRANSLATION[$header];
            $insertRow[":$databaseField"] = $row[$key];
        }
        insertIntoStagingArea($insertRow);
    }
}

function insertIntoStagingArea(array $values): void
{
    $pdo = Connect::getInstance();

    $insertSql = "INSERT INTO staging_area (
        codigo_pedido,
        produto,
        quant,
        valor_uni,
        valor_total,
        cliente,
        entregue_por,
        data_pedido,
        data_pagamento,
        data_liberacao,
        data_envio,
        data_receb
    ) VALUES (
        :codigo_pedido,
        :produto,
        :quant,
        :valor_uni,
        :valor_total,
        :cliente,
        :entregue_por,
        :data_pedido,
        :data_pagamento,
        :data_liberacao,
        :data_envio,
        :data_receb
    )";

    $pdo->prepare($insertSql)->execute($values);
}