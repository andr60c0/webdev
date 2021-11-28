<?php

$data = file_get_contents('shop.txt');
$array = json_decode($data, true);

foreach ($array as &$item) {
    $title = $item["title"];
    $price = $item["price"];
    echo "Name: $title price: $price <br/>";
}
