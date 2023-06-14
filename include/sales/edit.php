<?php

require_once __DIR__ . "/../utils.php";
// require_once __DIR__ . "/../search.php";
require_once __DIR__ . "/show.php";
/**
 * Membuat function untuk untuk melakukan pengeditan atau perubahan terhadap item yang telah dipilih atau yang ada pada 
 * $order dimana setelah disimpan apabila jumlah item diubah menjadi lebih besar daripada jumlah item sebelumnya
 * maka kurangi nilai stok item tersebut pada $vegetables sebesar (jumlah item sebelumnya - jumlah item yang baru)  
 * Sebaliknya apabila jumlah item yang diubah menjadi lebih kecil daripada sebelumnya
 * maka tambahkan nilai stok item tersebut pada $vegetables sebesar (jumlah item yang baru - jumlah item sebelumnya)
 */
function editItemOrder(array $ordersData, array $vegetableData)
{
    while (true) {
        if (count($ordersData) == 0) {
            echo "Tidak dapat melakukan pengeditan karena data order masih kosong. \n";
            echo "\n-------";
            return $ordersData;
        } else {
            // Tmapilkan hasil order yang terdapat pada $ordersData
            showOrderItems($ordersData);

            echo "\n";
            //meminta inputan ordinal number yang nantinya akan di edit jumlahnya dimana function ini akan langsung mereturn
            // id dari index yang dipilih 
            $orderId = askInputNumberIndex($ordersData, "diubah jumlahnya");
            if ($orderId == -1) {
                echo "\nTidak ditemukan nomor item sayur yang diinput \n";
                echo "\n-------\n";
                // break;
                return $ordersData;
            }
            // mencari item yang sesuai dengan inputan id yang ada pada array $ordersData
            $theVegetableOrder = getVegetableById($orderId,  $ordersData);
            $theVegetable = getVegetableById($theVegetableOrder["itemId"], $vegetableData);
            // // meminta inputan kepada user jumlah barang yang akan diubah
            echo "Jumlah '" . $theVegetableOrder["name"] . "': ";
            // meminta inputan jumlah barang
            $quantityInput = readInputAsFloat();
            // jika tidak ada inputan akan ditampilkan pesan error
            if ($quantityInput == 0.0) {
                echo "Mohon input jumlah barang yang benar. \n";
            } else if ($quantityInput > $theVegetable["stock"]) {
                echo "Tidak dapat mengubah jumlah item barang yang melebihi jumlah stock. \n";
            } else {
                // lakukan perulangan untuk mengecek apakah ada id yang sama antara id dari index yang diinput dengan id 
                //dari array ordersData
                for ($i = 0; $i < count($ordersData); $i++) {
                    if ($orderId == $ordersData[$i]["id"]) {
                        // jika ketemu atau ada yang sama maka orders data ke "i" quantitynya akan diubah sebanyak inputan user 
                        $ordersData[$i] = getOrder(vegetable: $theVegetableOrder, quantity: $quantityInput, id: $theVegetableOrder["id"]);
                        echo "Jumlah '" . $theVegetableOrder["name"] . "' diubah sebanyak " . $quantityInput;
                        break;
                    }
                }
            }
            break;
        }
    }
    // kembalikan data orders yang baru
    // saveOrdersIntoJson($ordersData);
    saveArrayIntoJson($ordersData, JSON_ORDERS);
    return $ordersData;
}
