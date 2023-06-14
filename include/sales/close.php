<?php

require_once __DIR__ . "/../utils.php";
require_once __DIR__ . "/show.php";
/**
 * Membuat function untuk penutupan transaksi, dimana setelah terjadinya penutupan ini, transaksi tidak bisa di rubah ataupun
 * dihapus karena transaksi sudah disimpan 
 */
function closeTransaction(array $vegetablesData, array &$ordersData, array $sales, array $salesItems, array $totalSalesItems)
{

    if (count($ordersData) == 0) {
        echo "Tidak dapat menyimpan transaksi karena data item (orders) masih kosong . \n";
        echo "-----\n";
        // break;
    } else {
        // menampilkan data yang ada pada array orders
        showOrderItems($ordersData);
        echo "\n";
        // meminta inputan nama pelanggan kepada user 
        $customerName = askCustomerName();

        $sentence = "Apakah anda yakin ingin menutup transaksi ini (y/n) ? ";
        if (continueInput($sentence) == false) {
            echo "Transaksi batal disimpan. \n";
            echo "-----\n";
        } else {
            $vegetablesData = editVegetableStock($vegetablesData, $ordersData);

            // build master of sales data and append into global $sales db
            $sales[] = buildSalesData(ordersData: $ordersData, salesData: $sales, name: $customerName);

            // build sales items data and append into global $salesItems db
            $masterId = $sales[count($sales) - 1]["id"];
            $salesItems = buildSalesItemData(order: $ordersData, salesItems: $salesItems, masterId: $masterId);

            //build total sales items data into global $totalSalesItems
            if (count($totalSalesItems) == 0) {
                $id = 0;
            } else {
                $id = $totalSalesItems[count($totalSalesItems) - 1]["id"] + 1;
            }

            for ($i = 0; $i < count($ordersData); $i++) {
                $order = $ordersData[$i];
                $totalSalesItems = buildTotalSalesItems(orderData: $order, totalSalesItems: $totalSalesItems, id: $id);
            }

            // menghapus data dalam array $orders
            unset($ordersData);

            $ordersData = [];
            echo "Transaksi telah disimpan! \n";
            echo "-----\n";
        }
        // break;
    }
    saveArrayIntoJson($vegetablesData, JSON_VEGETABLES);
    saveArrayIntoJson($ordersData, JSON_ORDERS);
    saveArrayIntoJson($sales, JSON_SALES);
    saveArrayIntoJson($salesItems, JSON_SALESITEMS);
    saveArrayIntoJson($totalSalesItems, JSON_TOTALSALESITEMS);

    return [$vegetablesData, $sales, $salesItems, $ordersData, $totalSalesItems];
}
