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
 * Membuat function untuk meminta inputan dari user berupa tipe data float 
 */
function readInputAsFloat(): float
{
    $input = trim(fgets(STDIN));
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
 * Membuat function untuk meminta inputan katagori sayur
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
 * Membuat function untuk mengecek apakah di dalam data ada nama sayur yang sama  
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
 * Membuat function untuk mencari data dari array $vegetable dengan menggunakan id
 */
function getVegetableById(int $id, array $vegetablesData): array
{

    for ($i = 0; $i < count($vegetablesData); $i++) {
        if ($id == $vegetablesData[$i]["id"]) {
            return $vegetablesData[$i];
        }
    }
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
 * Membuat function untuk melakukan pencarian jika yang diinput sama dengan nama sayur yang terdapat pada array $vegetable 
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

            $fixUnitPrice = number_format($salesItem[$i]["unitPrice"]);
            $fixSalesAmount = number_format($salesItem[$i]["price"]);
            echo "- " . $salesItem[$i]["quantity"] . " " . $theVegetables["name"]
                . " [Rp " . $fixUnitPrice . "] => Rp " . $fixSalesAmount . "\n";
        }
    }
}

/**
 * Membuat function untuk menambahkan data ke dalam array $order
 */
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
 * Membuat function untuk mendapatkan id 
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
            $unitPrice = $price / $quantity;
            $id = getId($salesItems);
            // if (count($salesItems) == 0) {
            //     $id = 0;
            // } else {
            //     $id = $salesItems[count($salesItems) - 1]["id"] + 1;
            // }

            $salesItems[] = array(
                "id" => $id,
                "masterId" => $masterId,
                "itemId" => $itemId,
                "quantity" => $quantity,
                "unitPrice" => $unitPrice,
                "price" => $price
            );
        }

        return $salesItems;
    }
}

/**
 * Membuat function untuk menambahkan jumlah harga sehingga mendapatkan total harga yang harus dibayar oleh pembeli
 */
function getTotalPrice(array $orders)
{
    $total = 0;
    for ($i = 0; $i < count($orders); $i++) {
        $total = $total + $orders[$i]["amount"];
    }
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
        $amount = getTotalPrice($ordersData);
        $quantity = getSumQuantity($ordersData);
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
 * Membuat function untuk mengecek apakah ada "itemId" yang sama dengan "itemid" yang ada di array orders dan array totalSalesItem
 * jika ada yang sama total amount akan ditambahkan dengan total amount sebelumnya
 */
function getTotalAmount(array $salesItem, array $orderData, int $amount): int
{


    if ($salesItem["itemId"] == $orderData["itemId"]) {
        $total = $salesItem["totalAmount"] + $orderData["amount"];
        return $total;
    } else {
        $total = $amount;
        return $total;
    }
}

/**
 * membuat function untuk mengecek quantity jika itemId yang ada pada array $totalSalesData sama maka akan ditambahkan 
 * 
 */
function getTotalQUantityItem(array $salesItem, array $orderData, float $quantity): float
{
    $total = 0.0;
    if ($salesItem["itemId"] == $orderData["itemId"]) {
        $total = $salesItem["totalQuantity"] + $orderData["quantity"];
        return $total;
    } else {
        $total = $quantity;
        return $total;
    }
}

/**
 * Membuat fuction untuk menambahkan data ke dalam array $totalSalesItems 
 */
function addTotalSalesItemData(array $orderData, array $totalSalesItems, int $id): array
{
    $itemId = $orderData["itemId"];
    $totalQuantity = $orderData["quantity"];
    $totalAmount = $orderData["amount"];
    $totalSalesItems[] = array(
        "id" => $id,
        "itemId" => $itemId,
        "totalQuantity" => $totalQuantity,
        "totalAmount" => $totalAmount,
    );
    // }
    return $totalSalesItems;
}

/**
 * Membuat function untuk mengedit atau memperbarui data dalam array $totalSalesItems
 */
function updateTotalSalesItemData(array $orderData, array $saleItem, int $id): array
{
    if ($saleItem["itemId"] == $orderData["itemId"]) {
        $totalQuantity = getTotalQUantityItem(salesItem: $saleItem, orderData: $orderData, quantity: $orderData["quantity"]);
        $totalAmount = getTotalAmount(salesItem: $saleItem, orderData: $orderData, amount: $orderData["amount"]);

        return array(
            "id" => $id,
            "itemId" => $orderData["itemId"],
            "totalQuantity" => $totalQuantity,
            "totalAmount" => $totalAmount,
        );
    }
}


/**
 * Membuat function untuk mengecek id apaakah ada yang sama atau tidak
 */
function checkId(array $totalSalesItems, int $itemId): bool
{
    for ($i = 0; $i < count($totalSalesItems); $i++) {
        if ($totalSalesItems[$i]["itemId"] == $itemId) {

            return true;
        }
    }

    return false;
}
/**
 * Membuat function untuk menambahkan array $totalSalesItems array ini akan menampug jumlah item yang terjual
 * dan juga menampung total jumlah uang yang didapat dari penjualan item tersebut. array ini nantinya akan digunakan pada 
 * saat mencari besar omzet dari hasil penjualan dan juga utuk mencari sayur terfavorite
 */
function buildTotalSalesItems(array $orderData, array $totalSalesItems, int $id): array
{

    if (count($totalSalesItems) == 0) {
        $totalSalesItems = addTotalSalesItemData(orderData: $orderData, totalSalesItems: $totalSalesItems, id: $id);
        return $totalSalesItems;
    } else {
        $checkId = checkId($totalSalesItems, $orderData["itemId"]);
        if ($checkId == false) {
            $totalSalesItems = addTotalSalesItemData(orderData: $orderData, totalSalesItems: $totalSalesItems, id: $id);
            return $totalSalesItems;
        } else {
            for ($a = 0; $a < count($totalSalesItems); $a++) {

                if ($totalSalesItems[$a]["itemId"] == $orderData["itemId"]) {
                    $saleItem = $totalSalesItems[$a];
                    $totalSalesItems[$a] = updateTotalSalesItemData(orderData: $orderData, saleItem: $saleItem, id: $id);
                }
            }
        }

        return $totalSalesItems;
    }
}


/**
 * Membuat function untuk mengsorting data $totalSalesItems untuk mendapatkan data sayur terfavorit berdsarkan quantitas dan amount
 */
function sortDataByQuantity(array $totalSalesItems)
{
    for ($i = 1; $i < count($totalSalesItems); $i++) {
        $totalQuantity = $totalSalesItems[$i]["totalQuantity"];
        $item = $totalSalesItems[$i];
        $j = $i - 1;
        while ($j >= 0 && $totalSalesItems[$j]["totalQuantity"] < $totalQuantity) {
            $totalSalesItems[$j + 1] = $totalSalesItems[$j];
            $j = $j - 1;
        }
        $totalSalesItems[$j + 1] = $item;
    }
    return $totalSalesItems;
}

/**
 * Membuat function untuk mengsorting data $totalSalesItems untuk mendapatkan data sayur terfavorit berdasarkan total Amount
 */
function sortDataByAmount(array $totalSalesItems)
{
    for ($i = 1; $i < count($totalSalesItems); $i++) {
        $totalAmount = $totalSalesItems[$i]["totalAmount"];
        $item = $totalSalesItems[$i];
        $j = $i - 1;
        while ($j >= 0 && $totalSalesItems[$j]["totalAmount"] < $totalAmount) {
            $totalSalesItems[$j + 1] = $totalSalesItems[$j];
            $j = $j - 1;
        }
        $totalSalesItems[$j + 1] = $item;
    }
    return $totalSalesItems;
}

/**
 * Membuat function untuk menyimpan data inputan user ke dalam file menggunakan json dimana inputan dari user
 * ini akan di simpan di dalam sebuah file dengan nama "vegetables.json" sehingga pada saat keluar dari program
 * data akan tetap tersimpan di dalam file   
 */
function saveVegetablesIntoJson(array $vegetables)
{
    $json = json_encode($vegetables);
    $jsonVegetables = file_put_contents("vegetables.json", $json);
}

/**
 * Membuat function untuk menyimpan data dari inputan user kedalam file menggunakan json, dimana inputan dari 
 * user ini akan di simpan di dalam sebuah file dengan nama "sales.json" sehingga pada saat keluar dari program
 * data akan tetap tersimpan di dalam file 
 */
function saveSalesIntoJson(array $sales)
{
    $json = json_encode($sales);
    $jsonSales = file_put_contents("sales.json", $json);
}

/**
 * Membuat function untuk menyimpan data dari inputan user kedalam file menggunakan json, dimana inputan dari 
 * user ini akan di simpan di dalam sebuah file dengan nama "salesItem.json" sehingga pada saat keluar dari program
 * data akan tetap tersimpan di dalam file 
 */
function saveSalesItemsIntoJson(array $salesItems)
{
    $json = json_encode($salesItems);
    $jsonSalesItems = file_put_contents("salesItems.json", $json);
}
/**
 * Membuat function untuk menyimpan data dari inputan user kedalam file menggunakan json, dimana inputan dari 
 * user ini akan di simpan di dalam sebuah file dengan nama "orders.json" sehingga pada saat keluar dari program
 * data akan tetap tersimpan di dalam file   
 */
function saveOrdersIntoJson(array $orders)
{
    $json = json_encode($orders);
    $jsonOrders = file_put_contents("orders.json", $json);
}
/**
 * Membuat function untuk menyimpan data dari inputan user kedalam file menggunakan json, dimana inputan dari 
 * user ini akan di simpan di dalam sebuah file dengan nama "totalSalesItems.json" sehingga pada saat keluar dari program
 * data akan tetap tersimpan di dalam file   
 */
function saveTotalSalesItemsIntoJson(array $totalSalesItems)
{
    $json = json_encode($totalSalesItems);
    $jsonTotalSalesItems = file_put_contents("totalSalesItems.json", $json);
}

/**
 * Membuat function untuk membaca atau mengembalikan file array persons dari encode menjadi array php (array seperti biasa)
 * ini berguna pada saat ingin memasukkan data baru dan diletakkan di file index sebelum menu tampil 
 * dan juga untuk menampilkan data yang sudah diinput sebelumnya 
 */
function loadVegetablesFromJson()
{
    // membuat sebuah variabel untuk menampung nama file yang sudah dibuat
    $file = "vegetables.json";
    // melakukan pengecekan terhadap file, apakah didalam file terdapat data atau tidak, jika ada maka lakukan
    if (file_exists($file)) {
        $vegetables = file_get_contents($file);
        // melakukan decode untuk mengubah bentuk dari json menjadi bentuk array yang sesuai dengan php (array semula)
        $json = json_decode($vegetables, true);
        // kembalikan nilai dengan bentuk array semula atau sesuai dengan php
        return $json;
    } else {
        // jika tidak ada data dalam filenya maka akan dikembalikan dengan nilai array kosong
        return [];
    }
}

function loadSalesFromJson()
{
    $file = "sales.json";

    if (file_exists($file)) {
        $sales = file_get_contents($file);
        $json = json_decode($sales, true);
        return $json;
    } else {
        return [];
    }
}

function loadSalesItemsFromJson()
{
    $file = "salesItems.json";

    if (file_exists($file)) {
        $salesItems = file_get_contents($file);
        $json = json_decode($salesItems, true);
        return $json;
    } else {
        return [];
    }
}

function loadOrdersFromJson()
{
    $file = "orders.json";

    if (file_exists($file)) {
        $orders = file_get_contents($file);
        $json = json_decode($orders, true);
        return $json;
    } else {
        return [];
    }
}

function loadTotalSalesItemsFromJson()
{
    $file = "totalSalesItems.json";

    if (file_exists($file)) {
        $totalSalesItems = file_get_contents($file);
        $json = json_decode($totalSalesItems, true);
        return $json;
    } else {
        return [];
    }
}
