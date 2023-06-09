<?php

require_once __DIR__ . "/utils.php";
require_once __DIR__ . "/search.php";
require_once __DIR__ . "/vegetables/create.php";
require_once __DIR__ . "/vegetables/edit.php";
require_once __DIR__ . "/vegetables/delete.php";
require_once __DIR__ . "/sales/search.php";
require_once __DIR__ . "/sales/create.php";
require_once __DIR__ . "/sales/show.php";
require_once __DIR__ . "/sales/edit.php";
require_once __DIR__ . "/sales/delete.php";
require_once __DIR__ . "/sales/close.php";
require_once __DIR__ . "/report/omzet.php";
require_once __DIR__ . "/report/favorite.php";


/**
 * Membuat sub menu dari menu 1 yaitu sayuran 
 */
function vegetablesMenu(array &$vegetables, array $salesItems)
{
    // global $vegetables;
    $spacer = "\n==========\n";
    while (true) {
        echo "KELOLA SAYURAN \n";
        echo "  1. Cari \n";
        echo "  2. Tambah \n";
        echo "  3. Ubah \n";
        echo "  4. Hapus \n";
        echo "  5. Tampilkan data\n";
        echo "  6. Ke Menu Utama \n";
        echo "Pilih Menu: ";
        $input = readInputAsInt();
        echo "\n";
        if ($input == 1) {
            searchVegetables($vegetables);
            echo $spacer;
        } else if ($input == 2) {
            $vegetables = insertVegetable($vegetables);
            echo $spacer;
        } else if ($input == 3) {
            $vegetables = editVegetable($vegetables);
            echo $spacer;
        } else if ($input == 4) {
            $vegetables = deleteVegetable($vegetables, $salesItems);
        } else if ($input == 5) {
            showVegetables($vegetables);
            echo $spacer;
        } else if ($input == 6) {
            echo "Kembali ke menu utama. ";
            break;
        } else {
            echo "Pilih menu dari nomor 1 sampai 6. \n";
            echo $spacer;
        }
    }
}

/**
 * Membuat sub menu untuk menu tambah pada menu 2 di salses menu 
 */
function transaction()
{
    global $vegetables;
    global $sales;
    global $salesItems;
    global $orders;
    global $totalSalesItems;

    $spacer = "\n==========\n";
    while (true) {
        echo "NOTA PENJUALAN \n";
        echo "  1. Tampilkan \n";
        echo "  2. Tambah item \n";
        echo "  3. Ubah jumlah item \n";
        echo "  4. Hapus item \n";
        echo "  5. Tutup transaksi \n";
        echo "  6. Batal / kembali \n";
        echo "Pilih Menu: ";
        $input = readInputAsInt();
        echo "\n";
        if ($input == 1) {
            showOrderItems($orders);
            echo $spacer;
        } else if ($input == 2) {
            $orders = insertItemOrder($vegetables, $orders);
            echo $spacer;
        } else if ($input == 3) {
            $orders = editItemOrder($orders, $vegetables);
            echo $spacer;
        } else if ($input === 4) {
            $orders = deleteItemOrder($orders);
        } else if ($input == 5) {
            $closedTrxData = closeTransaction(
                vegetableData: $vegetables,
                ordersData: $orders,
                sales: $sales,
                salesItems: $salesItems,
                totalSalesItems: $totalSalesItems
            );
            // $closedTrxData[0] => vegetables
            // $closedTrxData[1] => $sales
            // $closedTrxData[2] => $salesItem
            $vegetables = $closedTrxData[0];
            $sales = $closedTrxData[1];
            $salesItems = $closedTrxData[2];
            $orders = $closedTrxData[3];
            $totalSalesItems = $closedTrxData[4];
        } else if ($input == 6) {
            echo "Kembali ke menu penjualan\n";

            break;
        } else {
            echo "Pilih menu dari no 1 sampai 6. \n";
            echo $spacer;
        }
    }
}

/**
 * Membuat sub menu dari menu 2 yaitu penjualan (sales)
 */
function salesMenu()
{
    global $vegetables;
    global $sales;
    global $salesItems;
    // global $orders;

    $spacer = "\n==========\n";
    while (true) {
        echo "PENJUALAN: \n";
        echo "  1. Cari \n";
        echo "  2. Tambah \n";
        echo "  3. Menu utama \n";
        echo "Pilih Menu: ";
        $input = readInputAsInt();
        echo "\n";
        if ($input == 1) {
            searchSales($vegetables, $sales, $salesItems);
            echo $spacer;
        } else if ($input == 2) {
            transaction();
            echo $spacer;
        } else if ($input == 3) {
            echo "Kembali ke menu utama.";

            break;
        } else {
            echo "Pilih menu dari no 1 sampai 3. \n";
            echo $spacer;
        }
    }
}

/**
 * Membuat function untuk menu 3 yaitu pelaporan 
 */
function reportTransaction(array $sales, array $totalSalesItems, array $vegetables)
{
    $spacer = "\n==========\n";
    while (true) {
        echo "LAPORAN \n";
        echo "  1. Omzet \n";
        echo "  2. Sayur favorite \n";
        echo "  3. Menu Utama \n";
        echo "Pilih Menu: ";
        $input = readInputAsInt();
        if ($input == 1) {
            omzet($sales);
            echo $spacer;
        } else if ($input == 2) {
            bestVegetables($totalSalesItems, $vegetables);
            echo $spacer;
        } else if ($input == 3) {
            echo "Ke menu utama \n";

            break;
        } else {
            echo "Pilih menu dari no 1 sampai 3 saja, \n";
            echo $spacer;
        }
    }
}
/**
 * Membuat function untuk menampilkan menu utama 
 */
function mainMenu()
{
    echo "JUAL SAYUR \n";
    echo "  1. Sayuran \n";
    echo "  2. Penjualan \n";
    echo "  3. Laporan \n";
    echo "  4. Keluar \n";
    echo "Pilih Menu: ";
}

/**
 * Membuat function main untuk dipanggil di index
 */
function main()
{
    global $vegetables;
    global $sales;
    global $salesItems;
    global $totalSalesItems;

    $spacer = "\n==========\n";
    while (true) {
        echo mainMenu();
        $menu = readInputAsInt();
        echo "\n";
        if ($menu == 1) {
            vegetablesMenu($vegetables, $salesItems);
            echo $spacer;
        } else if ($menu == 2) {
            salesMenu();
            echo $spacer;
        } else if ($menu == 3) {
            reportTransaction($sales, $totalSalesItems, $vegetables);
            echo $spacer;
        } else if ($menu == 4) {
            echo "Keluar. \n";
            break;
        } else {
            echo "Pilih menu dari no 1 sampai 4. \n";
            echo $spacer;
        }
    }
}
