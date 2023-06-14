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
function deleteVegetable(array $vegetablesData, array $salesItem)
{

    // while (true) {
    if (count($vegetablesData) == 0) {
        echo "Tidak dapat melakukan penghapusan karena data sayur asih kosong. \n";
        // break;
    } else {
        // menampung hasil pencarian item sayur yang akan dihapus
        $searchResults = searchVegetables($vegetablesData);
        if (count($searchResults) == 0) {
            // break;
            return $vegetablesData;
        }
        // mencari id dari item yang akan dihapus atau yang dipilih oleh user
        $id = askInputNumberIndex($searchResults, "dihapus");
        if ($id == -1) {
            echo "\nTidak ditemukan nomor sayur yang diinput \n";
            echo "\n-------\n";
            // break;
        }

        // jika id sudah di dapat akan dilanjutkan dengan penghapusan data sayur
        $theVegetable = getVegetableById($id, $vegetablesData);
        for ($i = 0; $i < count($salesItem); $i++) {
            // jika data id sayur sudah ada atau sama dengan itemId yang ada pada array $salesItem maka data sayur tidak akan dihapus
            if ($id == $salesItem[$i]["itemId"]) {
                echo "Maaf, data '" . $theVegetable["name"]
                    . "' tidak dapat dihapus karena sudah ada data penjualannya! ";
                echo "\n=======\n";
                echo "\n";
                return $vegetablesData;
            }
        }


        //jika data id tidak ada yang sama dengan "itemId" maka lakukan perulangan untuk mengecek apaka ada id yang sama 
        // dengan id pada $vegetables, jika ada akan dilanjutkan dengan penghapusan
        for ($j = 0; $j < count($vegetablesData); $j++) {
            if ($id == $vegetablesData[$j]["id"]) {
                $sentence = "Yakin akan menghapus '" . $theVegetable["name"] . "' (y/n): ";
                if (continueInput($sentence) == false) {
                    echo "'" . $theVegetable["name"] . "' batal dihapus. \n";
                    echo "=======\n";
                    break;
                    // return $vegetableData;
                } else {
                    // todo: else?
                    unset($vegetablesData[$j]);
                    $vegetablesData = array_values($vegetablesData);
                    echo "'" . $theVegetable["name"] . "' telah dihapus!";
                    echo "\n=======\n";
                    break;
                    // return $vegetableData;
                }
            }
        }
        // todo: ini sepertinya dipindahkan ke else? di atas deh
        // $vegetableData = array_values($vegetableData);
        // echo "'" . $theVegetable["name"] . "' telah dihapus!";
        // echo "\n=======\n";
        // break;
        // }
    }

    // saveVegetablesIntoJson($vegetablesData);
    saveArrayIntoJson($vegetablesData, JSON_VEGETABLES);
    return $vegetablesData;
    // }
}
