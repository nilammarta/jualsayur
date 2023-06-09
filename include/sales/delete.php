<?php

require_once __DIR__ . "/../utils.php";
require_once __DIR__ . "/show.php";

/**
 * Membuat function untuk menghapus item pada array order 
 */
function deleteItemOrder(array $ordersData)
{
    while (true) {
        if (count($ordersData) == 0) {
            // todo: "tidak dapat melakukan penghapusan..."
            echo "Tidak dapat melakukan penghapusan karena data order masih kosong. \n";
            echo "\n-------";
            break;
        } else {
            showOrderItems($ordersData);

            echo "\n";
            $orderId = askInputNumberIndex($ordersData, "dihapus");
            if ($orderId == -1) {
                echo "\nTidak ditemukan nomor item sayur yang diinput \n";
                echo "\n-------\n";
                break;
            }

            $theVegetableOrder = getVegetableById($orderId, $ordersData);
            for ($i = 0; $i < count($ordersData); $i++) {
                if ($orderId == $ordersData[$i]["id"]) {

                    unset($ordersData[$i]);
                    $ordersData = array_values($ordersData);
                    echo  "'" . $theVegetableOrder["name"] . "' telah dihapus dari nota penjualan \n";
                    echo "\n=======\n";
                    // break;
                    return $ordersData;
                }
            }

            // todo: ini semestinya ada tepat setelah unset() di atas
            // $ordersData = array_values($ordersData);
            // echo  "'" . $theVegetableOrder["name"] . "' telah dihapus dari nota penjualan \n";
            // echo "\n=======\n";
            // break;
        }
    }
    return $ordersData;
}
