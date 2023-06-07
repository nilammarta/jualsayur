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
            $fixSalesAmount = number_format($salesItem[$i]["price"]);
            echo "- " . $salesItem[$i]["quantity"] . " " . $theVegetables["name"]
                . " [Rp " . $fixVegetablesPrice . "] => Rp " . $fixSalesAmount . "\n";
        }
    }
}

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
function buildSalesItemData(array $order, array $salesItems, int $masterId): array
{
    while (true) {
        // $array = [];
        for ($i = 0; $i < count($order); $i++) {
            $itemId = $order[$i]["itemId"];
            $quantity = $order[$i]["quantity"];
            $price = $order[$i]["amount"];
            // $id = getId($salesItems);
            if (count($salesItems) == 0) {
                $id = 0;
            } else {
                $id = $salesItems[count($salesItems) - 1]["id"] + 1;
            }

            $salesItems[] = array(
                "id" => $id,
                "masterId" => $masterId,
                "itemId" => $itemId,
                "quantity" => $quantity,
                "price" => $price
            );
        }

        return $salesItems;
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
    // $fixTotal = number_format($total);
    return $total;
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
 * Membuat function untuk menambahkan data pada data $sales
 */
function buildSalesData(array $ordersData, array $salesData, string $name): array
{
    while (true) {
        // $customerName = askCustomerName();
        $amount = getTotalPrice($ordersData);
        $quantity = getSumQuantity($ordersData);
        // $date = getDateTransaction();
        $time = time();
        $id = getId($salesData);

        return array(
            "id" => $id,
            "createdAt" => $time,
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
    }

    return $vegetables;
}

/**
 * Membuat fuction untuk menambahkan data ke dalam array $totalSalesItems 
 */
function addTotalSalesItemData(array $ordersData, array $totalSalesItems, int $id): array
{
    for ($i = 0; $i < count($ordersData); $i++) {
        $itemId = $ordersData[$i]["itemId"];

        // $totalQuantity = $ordersData[$i]["quantity"];
        $totalQuantity = getTotalQUantityItem(totalSalesItems: $totalSalesItems, ordersData: $ordersData, quantity: $ordersData[$i]["quantity"]);
        // $totalAmount = $ordersData[$i]["amount"];
        $totalAmount = getTotalAmount(ordersData: $ordersData, totalSalesItems: $totalSalesItems, amount: $ordersData[$i]["amount"]);
        $totalSalesItems[] = array(
            "id" => $id,
            "itemId" => $itemId,
            "totalQuantity" => $totalQuantity,
            "totalAmount" => $totalAmount,
        );
    }
    return $totalSalesItems;
}

/**
 * Membuat functio untuk mengedit atau memperbarui data dalam array$totalSalesItems
 */
function editTotalSalesItemData(array $ordersData, array $totalSalesItems, int $id): array
{
    for ($i = 0; $i < count($ordersData); $i++) {
        $itemId = $ordersData[$i]["itemId"];
        for ($a = 0; $a < count($totalSalesItems); $a++) {
            if ($totalSalesItems[$a]["itemId"] ==  $ordersData[$i]["itemId"]) {
                // $totalQuantity = $ordersData[$i]["quantity"];
                $totalQuantity = getTotalQUantityItem(totalSalesItems: $totalSalesItems, ordersData: $ordersData, quantity: $ordersData[$i]["quantity"]);
                // $totalAmount = $ordersData[$i]["amount"];
                $totalAmount = getTotalAmount(ordersData: $ordersData, totalSalesItems: $totalSalesItems, amount: $ordersData[$i]["amount"]);
                $totalSalesItems[$a] = array(
                    "id" => $id,
                    "itemId" => $itemId,
                    "totalQuantity" => $totalQuantity,
                    "totalAmount" => $totalAmount,
                );
                return $totalSalesItems;
            } else {
                $totalQuantity = getTotalQUantityItem(totalSalesItems: $totalSalesItems, ordersData: $ordersData, quantity: $ordersData[$i]["quantity"]);
                // $totalAmount = $ordersData[$i]["amount"];
                $totalAmount = getTotalAmount(ordersData: $ordersData, totalSalesItems: $totalSalesItems, amount: $ordersData[$i]["amount"]);
                $totalSalesItems[] = array(
                    "id" => $id,
                    "itemId" => $itemId,
                    "totalQuantity" => $totalQuantity,
                    "totalAmount" => $totalAmount,
                );
            }
        }
    }
    return $totalSalesItems;
}

/**
 * Membuat function untuk menambahkan array $totalSalesItems array ini akan menampug jumlah item yang terjual
 * dan juga menampung total jumlah uang yang didapat dari penjualan item tersebut. array ini nantinya akan digunakan pada 
 * saat mencari besar omzet dari hasil penjualan dan juga utuk mencari sayur terfavorite
 */
function buildTotalSalesItems(array $ordersData, array $totalSalesItems, int $id): array
{
    if (count($totalSalesItems) == 0) {
        $appendData = addTotalSalesItemData(ordersData: $ordersData, totalSalesItems: $totalSalesItems, id: $id);
        // return $appendData;
    } else {

        // if (count($totalSalesItems) == 0) {
        //     $appendData = addTotalSalesItemData(ordersData: $ordersData, totalSalesItems: $totalSalesItems, id: $id);
        //     return $appendData;
        // } else {
        $appendData = editTotalSalesItemData(ordersData: $ordersData, totalSalesItems: $totalSalesItems, id: $id);
    }
    return $appendData;
}


/**
 *Membuat function untuk mengecek apakah ada "itemId" yang sama dengan item id yang ada di array orders dan array totalSalesItem
 *  jika ada yang sama total amount akan ditambahkan dengan total amount sebelumnya
 */
function getTotalAmount(array $ordersData, array $totalSalesItems, int $amount): int
{
    if (count($totalSalesItems) == 0) {
        return $amount;
    } else {
        for ($i = 0; $i < count($totalSalesItems); $i++) {
            for ($a = 0; $a < count($ordersData); $a++) {
                if ($totalSalesItems[$i]["itemId"] == $ordersData[$a]["itemId"]) {
                    $total = $totalSalesItems[$i]["totalAmount"];
                    $total = $total + $ordersData[$a]["amount"];
                } else {
                    return $amount;
                }
            }
        }
        // return $totalSalesItems[$i]["totalAmount"];
        return $total;
    }
}

/**
 * membuat function untuk mengecek quantity jika itemId yang ada pada array $totalSalesData sama maka akan ditambahkan 
 * 
 */
function getTotalQUantityItem(array $totalSalesItems, array $ordersData, float $quantity): float
{
    if (count($totalSalesItems) == 0) {
        return $quantity;
    } else {
        for ($i = 0; $i < count($totalSalesItems); $i++) {
            for ($a = 0; $a < count($ordersData); $a++) {
                if ($totalSalesItems[$i]["itemId"] == $ordersData[$a]["itemId"]) {
                    $total = $totalSalesItems[$i]["totalQuantity"];
                    $total = $total + $ordersData[$a]["quantity"];
                } else {
                    return $quantity;
                }
            }
        }
        // return $totalSalesItems[$i]["totalQuantity"];
        return $total;
    }
}

/**
 * Membuat function untuk menjumlahkan semua amount yang ada pada data $sales
 */
function getSumAmount(array $sales): int
{
    $total = 0;
    for ($i = 0; $i < count($sales); $i++) {
        $total = $total + $sales[$i]["amount"];
    }
    return $total;
}
