<?php

require_once __DIR__ . "/../utils.php";
require_once __DIR__ . "/../search.php";

/**
 * Membuat function untuk melakukan pengeditan tehadap data sayuran yang sudah ada dalam array $vegetables dengan
 *  meminta inputan nama sayuran yang akan dicari oleh user kemudian meminta no ordinal dari hasil pencarian dan 
 * dilanjutkan dengan pengeditan 
 */
function editVegetable(array $vegetablesData)
{
    if (count($vegetablesData) == 0) {
        echo "Tidak dapat melakukan pengubahan karena data sayur masih kosong. \n";
    } else {
        // menampung hasil pencarian berdasarkan inputan oleh user
        $searchResults = searchVegetables($vegetablesData);
        if (count($searchResults) == 0) {
            return $vegetablesData;
        }
        //meminta inputan nomor dari user yang nantinya akan dikembalikan berupa id dari sayur yang dipilih atau -1
        $id = askInputNumberIndex($searchResults, "diubah");
        if ($id == -1) {
            echo "\nTidak ditemukan nomor sayur yang diinput \n";
        }
        // jika tidak akan dilanjutkan dengan pengeditan dimana id yang digunakan sama dengan id yang sebelumnya
        // lakukan perulangan untuk mencari id yang sama kemudian lanjutkan pengeditan
        for ($i = 0; $i < count($vegetablesData); $i++) {
            if ($id == $vegetablesData[$i]["id"]) {
                //meminta inputan nama sayur yang baru
                $newName = askVegetablesName();
                $vegetablesData[$i] = askVegetablesData($id, $newName);
                echo "'" . $newName . "' telah disimpan!";
                break;
            }
        }
        echo "\n-------\n";
    }

    // saveVegetablesIntoJson($vegetableData);
    return $vegetablesData;
}
