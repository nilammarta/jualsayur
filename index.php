<?php

require "include/main.php";

$vegetables = array(
    array(
        "id" => 0,
        "name" => "Kubis",
        "stock" => 25,
        "category" => "sayur daun",
        "price" => 10000
    ),
    array(
        "id" => 1,
        "name" => "Sawi",
        "stock" => 30,
        "category" => "sayur putih",
        "price" => 8000
    ),
    array(
        "id" => 2,
        "name" => "Lobak",
        "stock" => 20,
        "category" => "umbi",
        "price" => 3000
    ),

);


$sales = [];
// $sales = array(
//     array(
//         "id" => 10,
//         "createdAt" => 1686024106,
//         "customerName" => "Karin",
//         "amount" => 20000,
//         "quantity" => 4.5
//     ),
// );
//     array(
//         "id" => 11,
//         "createdAt" => "22 may 2023 09.14",
//         "customerName" => "Akila",
//         "amount" => 15000,
//         "quantity" => 4
//     ),
// );

$salesItems = [];
// $salesItems = array(
//     array(
//         "id" => 20,
//         "masterId" => 10,
//         "itemId" => 0,
//         "quantity" => 2,
//         "price" => 20000
//     ),
// );
//     array(
//         "id" => 30,
//         "masterId" => 10,
//         "itemId" => 1,
//         "quantity" => 2.5,
//         "price" => 20000
//     ),
//     array(
//         "id" => 40,
//         "masterId" => 11,
//         "itemId" => 2,
//         "quantity" => 4,
//         "price" => 15000
//     ),
// );

$orders = [];
// $orders = array(
//     array(
//         "id" => 0,
//         "name" => "kubis",
//         "quantity" => 10,
//         "itemId" => 0,
//         "price" => 1000,
//         "amount" => 10000,


//     ),
// );

$totalSalesItems = [];
// $totalSalesItems = array(
//     array(
//         "id" => 0,
//         "itemId" => 1,
//         "totalQuantity" => 2,
//         "totalAmount" => 200000
//     ),
// );

main();
