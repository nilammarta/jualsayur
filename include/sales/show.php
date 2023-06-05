<?php

require_once __DIR__ . "/../utils.php";

/**
 * Membuat function untuk menampilkan data transakasi yang sudah ada
 */

function showItemTransaction(array $ordersData)
{
    if (count($ordersData) == 0) {
        echo "Tidak ada data transaksi penjualan. \n";
    } else {
        $total = getTotalPrice($ordersData);
        echo "Total Rp " . $total . ": \n";
        for ($i = 0; $i < count($ordersData); $i++) {
            $fixPrice = number_format($ordersData[$i]["price"]);
            $fixAmount = number_format($ordersData[$i]["amount"]);
            echo $i + 1 . ". " . $ordersData[$i]["quantity"] . " " . $ordersData[$i]["name"] . " [Rp " . $fixPrice
                . "] => Rp " . $fixAmount . "\n";
        }
    }
}
