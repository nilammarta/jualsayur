<?php

require_once __DIR__ . "/../utils.php";
require_once __DIR__ . "/../search.php";

/**
 * Membuat function untuk melakukan pengeditan tehadap data sayuran yang sudah ada dalan array $vegetables
 * pertama meminta inputan nama sayuran yang akan dicari oleh user 
 */
function editVegetables(array $vegetableData)
{

    while (true) {
        if (count($vegetableData) == 0) {
            echo "Tidak dapat melakukan pengubahan karena data sayur masih kosong. \n";
        } else {

            $searchResult = searchVegetables($vegetableData);

            $id = askInputNumberIndex($searchResult, "diubah");
            if ($id == -1) {
                echo "\nTidak ditemukan nomor sayur yang diinput \n";
                echo "\n-------\n";
                break;
                // jika tidak akan dilanjutkan dengan pengeditan dimana id yang digunakan sama dengan id yang sebelumnya

            }
            // break;
            // lakukan perulangan untuk mencari id yang sama kemudian lanjutkan pengeditan
            for ($i = 0; $i < count($vegetableData); $i++) {
                if ($id == $vegetableData[$i]["id"]) {
                    $newName = askVegetablesName();
                    $vegetableData[$i] = askVegetablesData($id, $newName);
                    echo "'" . $newName . "' telah disimpan!";
                    break;
                }
            }
            echo "\n-------\n";
            break;
        }

        // return $vegetableData;
    }
    return $vegetableData;
}
