<?php

require_once __DIR__ . "/../utils.php";

/**
 * Membuat function untuk menampilkan jumlah omzet dari penjualam yang terjadi dengan cara mengcek pada array $sales 
 */
function omzet(array $salesData)
{
    if (count($salesData) == 0) {
        echo "Tidak dapat menampilkan omzet karena data penjualan masih kosong.\n";
        // return $salesData;
    } else {
        $total = 0;
        for ($i = 0; $i < count($salesData); $i++) {
            $total = $total + $salesData[$i]["amount"];
        }
        $fixAmount = number_format($total);
        echo "Omzet Rp " .  $fixAmount . " dari " . count($salesData) . " penjualan";
        echo "\n";
    }
}
