<?php

require_once __DIR__ . "/../utils.php";
require_once "show.php";
/**
 * Membuat function untuk pilihan transasi, dimana setelah terjadinya penutupan ini, transaksi tidak bisa di rubah ataupun
 * dihapus karena transaksi sudah disimpan 
 */
function closeTransaction(array $vegetableData, array &$ordersData, array $sales, array $salesItems)
{
    while (true) {
        if (count($ordersData) == 0) {
            echo "Tidak dapat menyimpan transaksi karena data item (orders) masih kosong . \n";
            echo "-----\n";
        } else {

            showItemTransaction($ordersData);
            echo "\n";
            $customerName = askCustomerName();
            // $id = getId($sales);
            $vegetableData[] = editVegetableStock($vegetableData, $ordersData);
            $sales[] = getSalesData(ordersData: $ordersData, salesData: $sales, name: $customerName);
            // $name = $sales[count($sales) - 1]["customerName"];
            for ($i = 0; $i < count($sales); $i++) {
                if ($customerName == $sales[$i]["customerName"]) {
                    $masterId = $sales[$i]["id"];
                    $salesItem[] = getSalesItemData(order: $ordersData, salesItems: $salesItems, masterId: $masterId);
                }
            }
            $sentence = "Apakah anda yakin ingin menutup transaksi ini (y/n) ? ";
            if (continueInput($sentence) == false) {
                echo "Transaksi batal disimpan. \n";
                echo "-----\n";
                //return $ordersData;
            } else {
                // menyimpan data ke array $sales dan $salesItem 
                unset($ordersData);
                echo "Transaksi telah disimpan! \n";
                echo "-----\n";
            }
            break;
        }
    }
    // return $salesItem;
    // return $ordersData;
    return [$vegetableData, $sales, $salesItems];
}
