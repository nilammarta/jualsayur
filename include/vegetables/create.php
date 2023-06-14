<?php

require_once __DIR__ . "/../utils.php";

/**
 * membuat function untuk menambah jenis sayuran oleh user dimana data yang diminta oleh user tidak boleh kosong
 * dan nama sayuran yang sudah ada di data tidak boleh di tambahkan lagi
 */
function insertVegetable(array $vegetablesData)
{
    // jika data tidak ada atau kosong akan langsung ditampilkan pesan eror
    // if (count($vegetablesData) == 0) {
    //     echo "Tidak ada data sayuran. \n";
    // } else {
    while (true) {
        // meminta inputan nama vegetable dari user
        $vegetablesName = askVegetablesName();
        // lakukakan pengecekan dari nama yang diinput oleh user apakah sudah ada atau atau belum di array data
        if (isNameExists($vegetablesData, $vegetablesName) == true) {
            // jika sudah ada, akan ditampilkan pesan
            echo  "Sayur dengan nama " . $vegetablesName . " sudah ada.\n";
        } else {
            //jika tidak akan dilanjutkan dengan eksekusi berikutnya yaitu penambahan data
            // jika belum ada datanya sama sekali, maka index yang pertama yaitu 0
            if (count($vegetablesData) == 0) {
                $id = 0;
                $vegetablesData[] = askVegetablesData($id, $vegetablesName);
                echo $vegetablesName . " telah disimpan! ";
            } else {
                // jika data sudah ada maka id akan ditambahkan (+1) dengan data sebelumnya
                $id = $vegetablesData[count($vegetablesData) - 1]["id"] + 1;
                $vegetablesData[] = askVegetablesData($id, $vegetablesName);
                echo $vegetablesName . " telah disimpan! ";
            }


            break;
        }
    }
    // }
    // saveVegetablesIntoJson($vegetablesData);
    saveArrayIntoJson($vegetablesData, JSON_VEGETABLES);
    return $vegetablesData;
}
