<?php

/**
 * Membuat function untuk membaca inputan dari user berupa integer, jika inputan salah maka return 0
 * (Make a function to read a input from user as integer)
 */
function readInputAsInt(): int
{
    $input = trim(fgets(STDIN));
    if (is_numeric($input)) {
        return (int) $input;
    }
    return 0;
}

/**
 * Membuat function untuk membaca inputan user berupa string
 * (Make a function to read a input from user as string)
 */
function readInputAsString(): string
{
    return trim(fgets(STDIN));
}

/**
 * Membuat function untuk membaca inputan user berupa float
 */
// function isFloat($input): bool
// {
//     // $input = trim(fgets(STDIN));
//     if (is_float($input)) {
//         return true;
//     } else {
//         return false;
//     }
// }

function readInputAsFloat(): float
{
    $input = trim(fgets(STDIN));
    // if (isFloat($input) == false) {
    //     return 0.0;
    // } else if (isFloat($input) == true) {
    //     return $input;
    // }
    $inputFloat = floatval($input);
    return $inputFloat;
}
/**
 * Membuat function untuk menanyakan kepada user apakah setuju atau tidak, dengan menggunakan parameter $sentence
 * yang bisa diubah-ubah isinya sesuai dengan output yang diinginkan 
 * (Make a function to ask the user that will be continue or not)
 */
function continueInput($sentence): bool
{
    while (true) {
        echo $sentence;
        $answer = trim(fgets(STDIN));
        if ($answer == "y") {
            return true;
        } else if ($answer == "n") {
            return false;
        }
    }
}

/**
 * Membuat function untuk meminta inputan nama sayur dari user
 */
function askVegetablesName(): string
{
    while (true) {
        echo "Nama Sayuran: ";
        $name = readInputAsString();
        // menghitung jumlah karakter pada string inputan
        $jumlahKarakter = strlen($name);
        if ($name == "") {
            echo "Mohon ketik nama sayuran yang benar. \n";
        } else if ($jumlahKarakter > 30) {
            echo "Karakter dari nama sayur tidak boleh dari 30 Karakter. \n";
        } else {
            return $name;
        }
    }
}

/**
 * Membuat function untuk meminta inputan katagori
 */
function askCategory(): string
{
    while (true) {
        echo "Kategori: ";
        $kategori = readInputAsString();
        $jumlahKarakter = strlen($kategori);
        if ($kategori == "") {
            echo "Mohon ketik kategori sayuran yang benar. \n";
        } else if ($jumlahKarakter > 30) {
            echo "Karakter dari kategori sayuran tidak boleh dari 30 Karakter. \n";
        } else {
            return $kategori;
        }
    }
}

/**
 * Membuat function untuk meminta inputan stok yang tersedia 
 */
function askStockData(): float
{
    while (true) {
        echo "Stok: ";
        $stok = readInputAsFloat();
        if ($stok == 0.0) {
            // return $stok;
            echo "Mohon input stock yang benar. \n";
        } else {
            return $stok;
            break;
        }
    }
}

/**
 * Membuat function untuk meminta inputan harga kepada user
 */
function askPrice(): int
{
    while (true) {
        echo "Harga Jual: ";
        $price = readInputAsInt();
        if ($price == 0) {
            echo "Mohon ketik harga jual yang benar. \n";
        } else {
            // $fixPrice = number_format($price);
            return $price;
        }
    }
}

/**
 * Membuat function untuk memanggil semua function di atas 
 */
function askVegetablesData(int $id, string $vegetableName): array
{
    while (true) {

        $category = askCategory();
        $stock = askStockData();
        $prices = askPrice();

        return array(
            "id" => $id,
            "name" => $vegetableName,
            "category" => $category,
            "stock" => $stock,
            "price" => $prices,

        );
    }
}

/**
 * Membuat function untuk menampilkan data sayuran sesuai output
 */
function showVegetables(array $vegetablesData)
{
    if (count($vegetablesData) == 0) {
        echo "Tidak dapat menampilkan data karena data sayur masih kosong. \n";
    } else {
        for ($i = 0; $i < count($vegetablesData); $i++) {
            $fixPrice = number_format($vegetablesData[$i]["price"]);
            echo "  " . $i + 1 . ". " . $vegetablesData[$i]["name"] . ", Rp " .  $fixPrice
                . " [stok: " . $vegetablesData[$i]["stock"] . "] [kategori: " . $vegetablesData[$i]["category"] . "] ";
            echo "\n";
        }
        echo "\n";
    }
}

/**
 * Membuat function untuk mengecek apakah di dalam data nama sayur yang sama 
 */
function isNameExists(array $data, string $name): bool
{
    for ($i = 0; $i < count($data); $i++) {
        if (preg_match("/$name/i", $data[$i]["name"])) {
            return true;
        }
    }
    return false;
}

/**
 * Membuat function untuk mengecek apakah inputan dari user lebih dari jumalah data dari hasil pencarian atau tidak
 */
function isInputIndex(array $search, int $input): bool
{
    if ($input > count($search) || $input <= 0) {
        return false;
    } else {
        return true;
    }
}

/**
 * Membuat function untuk meminta no urut dari data yang ditampilkan yang mana nanti akan dieksekusi 
 */
function askInputNumberIndex(array $search, $sentence): int
{
    echo "Pilih no urut yang akan " . $sentence . ": ";
    $input = readInputAsInt();
    $indexVegetable = $input - 1;

    if (isInputIndex($search, $input) == true) {
        return $search[$indexVegetable]["id"];
    } else {
        return -1;
    }
}

/**
 * Membuat function untuk mencari data dari vegetable dengan menggunakan id
 */
function getVegetableById(int $id, array $vegetablesData): array
{
    // $theVegetables = [];
    for ($i = 0; $i < count($vegetablesData); $i++) {
        if ($id == $vegetablesData[$i]["id"]) {
            return $vegetablesData[$i];
        }
    }
    // return null;
}

/**
 * Membuat function untuk melakukan pencarian dari customer name dimana akan di return berupa array 
 * yang isinya hanya id dari hasil pencarian
 */
function searchSalesByCustomerName(array $salesData, string $input): array
{
    $searchResult = [];
    for ($i = 0; $i < count($salesData); $i++) {
        if (preg_match("/$input/i", $salesData[$i]["customerName"])) {
            $searchResult[] = $salesData[$i]["id"];
        }
    }
    return array_unique($searchResult);
}

/**
 * Membuat function untuk melakukan pencarian jika yang diinput sama dengan nama sayur yang terdapat pada variable $vegetable 
 * jika ada, id nya akan ditampung di array temporary kemudian di return 
 */
function searchSalesByVegetableName(array $salesItem, array $vegetables, $input): array
{
    $searchResult = [];

    for ($i = 0; $i < count($vegetables); $i++) {
        if (preg_match("/$input/i", $vegetables[$i]["name"])) {

            for ($a = 0; $a < count($salesItem); $a++) {
                if ($vegetables[$i]["id"] == $salesItem[$a]["itemId"]) {
                    $searchResult[] = $salesItem[$a]["masterId"];
                }
            }
        }
    }

    return array_unique($searchResult);
}


/**
 * Membuat function untuk menampilkan hasil pembelian sayuran kepada pelanggan sesuai dengan output yang diminta
 */
function showSale(array $vegetables, array $salesItem, int $salesId)
{

    for ($i = 0; $i < count($salesItem); $i++) {

        if ($salesId == $salesItem[$i]["masterId"]) {
            $id = $salesItem[$i]["itemId"];
            $theVegetables = getVegetableById($id, $vegetables);
            $fixVegetablesPrice = number_format($theVegetables["price"]);
            echo "- " . $salesItem[$i]["quantity"] . " " . $theVegetables["name"]
                . " [Rp " . $fixVegetablesPrice . "] => Rp " . $salesItem[$i]["price"] . "\n";
        }
    }
}

/**
 * Membuat function untuk melakukan validasi dan juga megubah banyak stok sayur jika sudah disimpan pada nota penjualan
 */
// function editVegetableStock(array $vegetable, float $quantity): array
// {
//     while (true) {
//         // for ($i = 0; $i < count($vegetablesData); $i++) {
//         //     if ($vegetable["id"] == $vegetablesData[$i]["id"]) {
//         $id = $vegetable["id"];
//         $name = $vegetable["name"];
//         $category = $vegetable["category"];
//         $price = $vegetable["price"];
//         $newstock = $vegetable["stock"] - $quantity;

//         return array(
//             "id" => $id,
//             "name" => $name,
//             "category" => $category,
//             "stock" => $newstock,
//             "price" => $price,

//         );
//         //     }
//         // }
//         // return $vegetablesData;
//     }
// }

/**
 * Membuat function untuk mengubah stock yang ada pada array $vegetables  
 */
// function newStockVegetable(array $vegetablesData, array $ordersData): array
// {
//     if (count($ordersData) == 0) {
//         return $vegetablesData;
//     } else {
//         for ($i = 0; $i < count($vegetablesData); $i++) {
//             // for ($a = 0; $a < count($ordersData); $a++) {
//             $indexOrder = count($ordersData) - 1;
//             if ($vegetablesData[$i]["id"] == $ordersData[$indexOrder]["itemId"]) {
//                 $vegetablesData[$i] = editVegetableStock($vegetablesData[$i], $ordersData[$indexOrder]["quantity"]);
//                 return $vegetablesData;
//             }
//             // }
//         }
//     }
//     // return $vegetableData;
// }

/**
 * Membuat function untuk meen tukan total harga dari barang yang di beli dengan cara mengalikan harga dengan quantity
 */
// function getAmountPrice($price, $quantity)
// {
//     $priceTotal = $price * $quantity;
//     $fixPrice = number_format($priceTotal);
//     return $fixPrice;
// }

function getOrder(array $vegetable, float $quantity, int $id): array
{
    while (true) {
        $name = $vegetable["name"];
        $price = $vegetable["price"];
        // $priceTotal = getAmountPrice($price, $quantity);
        // $amount = 
        $itemId = $vegetable["id"];
        $priceTotal = $price * $quantity;

        return array(
            "id" => $id,
            "name" => $name,
            "itemId" => $itemId,
            "quantity" => $quantity,
            "price" => $price,
            "amount" => $priceTotal
        );
    }
}

/**
 * membuat function untuk mendapatkan id 
 */
function getId(array $array): int
{
    if (count($array) == 0) {
        $id = 0;
    } else {
        $id = $array[count($array) - 1]["id"] + 1;
    }

    return $id;
}

/**
 * Membuat function untuk mendapatkan array $salesItem (penjualan) dan menyimpannya dalam array $salesItem
 */
function buildSalesItemData(array $order, array $salesItems,  int $masterId): array
{
    while (true) {
        $array = [];
        for ($i = 0; $i < count($order); $i++) {
            $itemId = $order[$i]["itemId"];
            $quantity = $order[$i]["quantity"];
            $price = $order[$i]["amount"];
            // $id = getId($salesItem);
            if (count($salesItems) == 0) {
                $id = 0;
            } else {
                $id = $salesItems[count($salesItems) - 1]["id"] + 1;
            }

            $array[] = array(
                "id" => $id,
                "masterId" => $masterId,
                "itemId" => $itemId,
                "quantity" => $quantity,
                "price" => $price
            );
        }

        return $array;
    }
}

/**
 * Membuat function untuk menambahkan jumlah harga sehingga mendapatkan total harga yang harus dibayah oleh pembeli
 */
function getTotalPrice(array $orders)
{
    $total = 0;
    for ($i = 0; $i < count($orders); $i++) {
        $total = $total + $orders[$i]["amount"];
    }
    $fixTotal = number_format($total);
    return $fixTotal;
}

/**
 * Membuat function untuk menghitung jumlah semua barang yang dibeli
 */
function getSumQuantity(array $ordersData)
{
    $total = 0;
    for ($i = 0; $i < count($ordersData); $i++) {
        $total = $total + $ordersData[$i]["quantity"];
    }
    return $total;
}

/**
 * Membuat funcion untuk menentukan tanggal transaksi dibuat
 */
function getDateTransaction()
{
    $time = time();
    //$date = date("j F Y H:i", $time);
    return time();
}

/**
 * Membuat function untuk menambahkan data pada data $sales
 */
function buildSalesData(array $ordersData, array $salesData, string $name): array
{
    while (true) {
        // $customerName = askCustomerName();
        $amount = getTotalPrice($ordersData);
        $quantity = getSumQuantity($ordersData);
        $date = getDateTransaction();
        $id = getId($salesData);

        return array(
            "id" => $id,
            "createdAt" => $date,
            "customerName" => $name,
            "amount" => $amount,
            "quantity" => $quantity
        );
    }
}

/**
 * Membuat function untuk meminta inputan nama pelanggan oleh user pada saat menyimpan transaksi
 */
function askCustomerName(): string
{
    while (true) {
        echo "Nama Pelanggan: ";
        $input = readInputAsString();
        if ($input == "") {
            echo "Mohon input nama yang benar.\n";
        } else {
            return $input;
        }
    }
}

/**
 * Membuat function untuk mengurangi jumlah stock vegetables yang sesuai dengan jumlah quantity pada array orders
 */
function editVegetableStock(array $vegetables, array $orders): array
{
    if (count($orders) > 0) { {
        for ($i = 0; $i < count($vegetables); $i++) {
            for ($a = 0; $a < count($orders); $a++) {
                if ($vegetables[$i]["id"] == $orders[$a]["itemId"]) {
                    $vegetables[$i]["stock"] = $vegetables[$i]["stock"] - $orders[$a]["quantity"];
                }
            }
        }
    }

    return $vegetables;
}


/**
 * Membuat function untuk  
 */
// function getItemIdByInputId(array $vegetablesData, int $inputId): int
// {
//     // while (true) {
//     for ($i = 0; $i < count($vegetablesData); $i++) {
//         if ($vegetablesData[$i]["id"] == $inputId) {
//             $itemid = $inputId;
//             return $itemid;
//         }
//     }
//     // }
// }

// function getPrice(array $vegetablesData, float $quantity, int $itemId)
// {
//     for ($i = 0; $i < count($vegetablesData); $i++) {
//         if ($vegetablesData[$i]["id"] == $itemId) {
//             $price = $vegetablesData[$i]["price"] * $quantity;
//             $fixPrice = number_format($price);
//             return $fixPrice;
//         }
//     }
// }

// // function getId(array $salesItem)
// // {
// //     if (count ($salesItem) == 0){
// //         $id = 0;
// //     } else {
// //         $id = $salesItem[count($salesItem) - 1]["id"] + 1 ;
// //     }
// //     return $id;
// // }
// function addNewSalesItemsData(int $id, int $masterId, float $quantityInput, array $vegetableData, int $inputId): array
// {
//     while (true) {
//         $itemId = getItemIdByInputId($vegetableData, $inputId);
//         $price 
//     }
// }

// function insertSalesData(array $sales, array $orders, array $salesItem): array
// {
//     while (true) {
//         $masterId = $sales[count($sales) - 1]["id"];
//         // for ($i = 0; $i < count ($sales); $i++){
//         //     if ()
//         // }
//         $salesItem[] = getSalesItemData(order: $orders, salesItem: $salesItem, masterId: $masterId);
//         $sentence = "Apakah anda yakin ingin menutup transaksi ini (y/n) ? ";
//         if (continueInput($sentence) == false) {
//             echo "Transaksi batal disimpan. \n";
//             return $orders;
//         } else {
//             unset($orders);
//             echo "Transaksi telah disimpan! \n";
//             echo "-----\n";
//         }
//     }
//     return $salesItem;
// }
