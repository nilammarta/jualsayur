<?php

require_once __DIR__ .  "/../utils.php";
require_once __DIR__ . "/../search.php";

/**
 * Membuat function untuk menambahkan item pada nota sayuran yang ada pada data sayuran dimana function ini dapat digunakan 
 * untuk  menambahakan item sayuran ke nota sayuran dengan banyak sesuai dengan jumlah inputan olehuser dan saat transaksi 
 * penjualan ini sudah disimpan, maka stok masing" item harus dikurangi dengan jumlah yang diinput oleh user
 */

function insertItemOrder(array $vegetablesData, array $ordersData): array
{

    if (count($vegetablesData) == 0) {
        echo "Tidak dapat melakukan pembelian karena data sayur masih kosong. \n";
    } else {
        $searchResult = searchVegetables($vegetablesData);
        if (count($searchResult)  == 0) {
            return $ordersData;
        }

        $vegetableId = askInputNumberIndex($searchResult, "ditambahkan ke nota");
        if ($vegetableId == -1) {
            echo "\nTidak ditemukan nomor sayur yang diinput \n";
            echo "\n-------\n";
        } else {

            $theVegetable = getVegetableById($vegetableId, $vegetablesData);
            // validasi: cek apabila vegetable yg dipilih memiliki stock <= 0, maka tampilkan
            // pesan error: tidak dapat menambahkan item ke nota
            if ($theVegetable["stock"] <= 0) {
                echo "\n    Tidak dapat menambahkan '" . $theVegetable["name"]
                    . "' ke nota penjualan karena stok sayuran habis \n";
                return $ordersData;
            } else {
                while (true) {
                    echo "Jumlah '" . $theVegetable["name"] . "': ";
                    $totalInput = readInputAsFloat();
                    if ($totalInput == 0.0) {
                        echo "Mohon input jumlah barang yang benar. \n";
                    } else if ($totalInput > $theVegetable["stock"]) {
                        echo "Mohon untuk menginput jumlah item barang yang tidak melebihi stock barang. \n";
                    } else {
                        // $theVegetable = editVegetableStock($theVegetable, $totalInput);
                        if (count($ordersData) == 0) {
                            $orderId = 0;
                        } else {
                            $orderId = $ordersData[count($ordersData) - 1]["id"] + 1;
                        }
                        $ordersData[] = getOrder(vegetable: $theVegetable, quantity: $totalInput, id: $orderId);
                        echo "'" . $theVegetable["name"] . "' sebanyak " . $totalInput . " telah ditambahkan ke nota penjualan.";
                        echo "\n-------\n";
                        break;
                    }
                }
            }
        }
    }
    saveArrayIntoJson($ordersData, JSON_ORDERS);
    return $ordersData;
}
