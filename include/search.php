<?php

require_once "utils.php";

/**
 * Membuat function untuk melakukan pencarin data sayur menggunakan nama sayur yang ada
 * inputan dari user tidak memperhatikan huruf besar atau kecil, (case insensitive) jika ada karakter dari inputan
 * yang sama dengan karakter pada data maka itu akan di tampilkan nanti 
 */
function searchVegetables(array $vegetableData)
{
    if (count($vegetableData) == 0) {
        echo "Tidak dapat melakukan pencarian karena data sayur masih kosong . \n";
    } else {
        while (true) {
            $input = askVegetablesName();
            // echo "Nama sayuran: ";
            // Melakukan validasi ketika yang di input * atau simbol lainnya akan di tampilkan pesan eror
            // $input = preg_quote(readInputAsString());
            echo "Hasil pencarian: \n";
            // membuat srray temporary untuk menampung hasil pencarian
            $searchResult = [];
            // lakukan perulangan untuk melakukan pencarian
            for ($i = 0; $i < count($vegetableData); $i++) {
                if (preg_match("/$input/i", $vegetableData[$i]["name"])) {
                    $searchResult[] = $vegetableData[$i];
                }
            }

            if (count($searchResult) == 0) {
                echo "\nTidak ditemukan hasil pencarian. \n";
                echo "\n";
            } else {
                // tampilkan hasil pencarian 
                showVegetables($searchResult);
            }

            return $searchResult;
        }
    }
}
