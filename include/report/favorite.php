<?php

require_once __DIR__ . "/../utils.php";

/**
 * Membuat function untuk menampilkan sayur favorite berdasarkan banyak sayur yang terjual 
 * dan juga berdasarkan besar penjualan paling banyak
 */
function bestVegetables(array $totalSalesItems, array $vegetablesData)
{
    //melakukan sorting terhadap total quantity 
    $sortingQuantity = sortDataByQuantity($totalSalesItems);
    $sortingAmount = sortDataByAmount($totalSalesItems);

    echo "3 sayuran terfavorit (kuantitas) : \n";

    // rumus oneliner: 
    // (kondisi) ? jika_true : jika_false;
    $max = (count($sortingQuantity) > 3) ? 3 : count($sortingQuantity);

    for ($i = 0; $i < $max; $i++) {
        // if ($i < 4) {
        $itemId = $sortingQuantity[$i]["itemId"];
        $theVegetable = getVegetableById($itemId, $vegetablesData);

        echo "  " . $i + 1 . ". " . $theVegetable["name"] . ": " . $sortingQuantity[$i]["totalQuantity"] . " terjual \n";
        // }
    }

    echo "\n";

    echo "3 sayuran terfavorit (nominal) : \n";

    // one-liner codes
    $max = (count($sortingAmount) > 3) ? 3 : count($sortingAmount);

    for ($a = 0; $a < $max; $a++) {
        $itemId = $sortingAmount[$a]["itemId"];
        $fixAmount = number_format($sortingAmount[$a]["totalAmount"]);
        $theVegetables = getVegetableById($itemId, $vegetablesData);
        echo "  " . $a + 1 . ". " . $theVegetables["name"] . ": Rp " . $fixAmount . "\n";
    }
}
