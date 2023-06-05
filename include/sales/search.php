<?php

require_once __DIR__ . "/../utils.php";

/**
 * Membuat function untuk mencari transaksi penjualan yang pernah terjadi   
 */
function searchSales(array $vegetablesData, array $salesData, array $salesItemData)
{
    while (true) {
        if ($salesData == 0) {
            echo "Tidak dapat melakukan pencarian karena data penjualan masih kosong. \n";
            break;
        } else {
            echo "Cari (nama sayuran/pelanggan) : ";
            $vegetablesOrSalesName = readInputAsString();
            echo "Hasil pencarian: \n";
            echo "\n";
            $salesResult = searchSalesByCustomerName($salesData, $vegetablesOrSalesName);
            $vegetablesResult = searchSalesByVegetableName(salesItem: $salesItemData, vegetables: $vegetablesData, input: $vegetablesOrSalesName);
            $idSearchmerged = array_merge($salesResult, $vegetablesResult);
            // $idSearchResult = array_merge($salesResult, $vegetablesResult);
            $idSearchResult = array_unique($idSearchmerged);

            if (count($idSearchResult) == 0) {
                echo "Tidak ditemukan hasil pencarian yang sesuai dengan input. \n";
                echo "\n";
                break;
            } else {
                for ($i = 0; $i < count($idSearchResult); $i++) {
                    $id = $idSearchResult[$i];

                    for ($a = 0; $a < count($salesData); $a++) {
                        if ($id == $salesData[$a]["id"]) {
                            // $salesResultData = getSalesById($salesResult, $id);
                            echo $i + 1 . ". " .  $salesData[$a]["createdAt"] . " kepada " . $salesData[$a]["customerName"]
                                . ", total Rp " . $salesData[$a]["amount"] . ": \n";
                            showSale(vegetables: $vegetablesData, salesItem: $salesItemData, salesId: $id);
                            echo "\n";
                        }
                    }
                }

                break;
            }
        }
    }
}
