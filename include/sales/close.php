<?php

require_once __DIR__ . "/../utils.php";
require_once "show.php";
/**
 * Membuat function untuk pilihan transasi, dimana setelah terjadinya penutupan ini, transaksi tidak bisa di rubah ataupun
 * dihapus karena transaksi sudah disimpan 
 */
function closeTransaction(array $vegetableData, array &$ordersData, array $sales, array $salesItems, array $totalSalesItems)
{
    while (true) {
        if (count($ordersData) == 0) {
            echo "Tidak dapat menyimpan transaksi karena data item (orders) masih kosong . \n";
            echo "-----\n";
            break;
        } else {

            showItemTransaction($ordersData);
            echo "\n";
            $customerName = askCustomerName();
            // $id = getId($sales);

            $sentence = "Apakah anda yakin ingin menutup transaksi ini (y/n) ? ";
            if (continueInput($sentence) == false) {
                echo "Transaksi batal disimpan. \n";
                echo "-----\n";
                //return $ordersData;
            } else {
                $vegetableData = editVegetableStock($vegetableData, $ordersData);

                // build master of sales data and append into global $sales db
                $sales[] = buildSalesData(ordersData: $ordersData, salesData: $sales, name: $customerName);
                // $name = $sales[count($sales) - 1]["customerName"];

                // build sales items data and append into global $salesItems db
                for ($i = 0; $i < count($sales); $i++) {
                    if ($customerName == $sales[$i]["customerName"]) {
                        $masterId = $sales[$i]["id"];

                        $salesItems = buildSalesItemData(order: $ordersData, salesItems: $salesItems, masterId: $masterId);
                    }
                }

                //build total sales items data into global $totalSalesItems
                if (count($totalSalesItems) == 0) {
                    $id = 0;
                    // $totalSalesItems = addTotalSalesItemData(ordersData: $ordersData, totalSalesItems: $totalSalesItems, id: $id);
                } else {
                    $id = $totalSalesItems[count($totalSalesItems) - 1]["id"] + 1;
                    // $totalSalesItems = editTotalSalesItemData(ordersData: $ordersData, totalSalesItems: $totalSalesItems, id: $id);
                }
                $totalSalesItems = buildTotalSalesItems(ordersData: $ordersData, totalSalesItems: $totalSalesItems, id: $id);


                // menghapus data dalam array $orders
                unset($ordersData);

                $ordersData = [];
                echo "Transaksi telah disimpan! \n";
                echo "-----\n";
            }
            break;
        }
    }

    return [$vegetableData, $sales, $salesItems, $ordersData, $totalSalesItems];
}
