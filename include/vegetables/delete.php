<?php

require_once __DIR__ . "/../utils.php";
require_once __DIR__ . "/../search.php";

/**
 * Membuat funtion untuk melakukan penghapusan terhadap data sayuran yang ada pada data $vegetables
 * dimana jika sayuran sudah pernah terjual atau pada variabel $salesItem (penjualan) terdapat 
 * id yang sama dengan id yang akan di hapus, maka itu tidak bisa dihapus dan juga sebaliknya
 * jika tidak ada id yang sama dengan id yang terdapat pada variable penjualan maka akan dilanjutkan
 * dengan eksekusi penghapusan 
 */
function deleteVegetable(array $vegetableData, array $salesItem)
{

    while (true) {
        if (count($vegetableData) == 0) {
            echo "Tidak dapat melakukan penghapusan karena data sayur asih kosong. \n";
            break;
        } else {
            $searchResults = searchVegetables($vegetableData);
            if (count($searchResults) == 0) {
                break;
            }
            $id = askInputNumberIndex($searchResults, "dihapus");
            // $theVegetable = getVegetableById($id, $vegetableData);
            if ($id == -1) {
                echo "\nTidak ditemukan nomor sayur yang diinput \n";
                echo "\n-------\n";
                break;
            }

            $theVegetable = getVegetableById($id, $vegetableData);
            for ($i = 0; $i < count($salesItem); $i++) {
                if ($id == $salesItem[$i]["itemId"]) {
                    echo "Maaf, data '" . $theVegetable["name"]
                        . "' tidak dapat dihapus karena sudah ada data penjualannya! ";
                    echo "\n=======\n";
                    echo "\n";
                    // break;
                    return $vegetableData;
                }
            }

            for ($j = 0; $j < count($vegetableData); $j++) {
                if ($id == $vegetableData[$j]["id"]) {
                    $sentence = "Yakin akan menghapus '" . $theVegetable["name"] . "' (y/n): ";
                    if (continueInput($sentence) == false) {
                        echo "'" . $theVegetable["name"] . "' batal dihapus. \n";
                        echo "=======\n";
                        // break;
                        return $vegetableData;
                    } else {
                        // todo: else?
                        unset($vegetableData[$j]);
                        $vegetableData = array_values($vegetableData);
                        echo "'" . $theVegetable["name"] . "' telah dihapus!";
                        echo "\n=======\n";
                        // break;
                        return $vegetableData;
                    }
                }
            }
            // todo: ini sepertinya dipindahkan ke else? di atas deh
            // $vegetableData = array_values($vegetableData);
            // echo "'" . $theVegetable["name"] . "' telah dihapus!";
            // echo "\n=======\n";
            // break;
        }

        return $vegetableData;
    }
    // return $vegetableData;
}
