<?php
session_start();
checkLogin();

$title = "catalogusproducten";

require_once('includes/database.php');
require_once('includes/functions.php');
require_once('includes/header.php');

// ophalen van producten: $producten = getItems();

$index = 0;
foreach($producten as $item){
    $product[$index] = "<h2>" . $item['titel'] . "</h2> <br>";
    $product[$index] .= "<p>" . $item['prijs'] . "</p> <br>";
    // hoe moet je elk bestand checken?
    if(file_exists('EenmaalAndermaalDEF\Images\hond.jpg')){
        $product[$index] .= "<img src=''EenmaalAndermaalDEF\Images\hond.jpg' alt='Foto van product'>";
    } else {
        $product[$index] .= "<img src='" . $item['afbeelding'] . ".png' alt='Fotooooooo van product'";
    }
    echo $product[$index];
}

require_once('includes/footer.php');

