<?php
session_start();
require_once('includes/functions.php');
checkLogin();
$parameterList = array("Titel", "Beschrijving", "Rubriek", "img", "Startprijs", "Betalingswijze", "Betalingsinstructie", "Looptijd",
    "Verzendinstructies");
$user = User::getUser($_SESSION["name"]);
if ($user["Verkoper"]) {
    if(checkPost()) {
        if (isset($_POST["Titel"]) && isset($_POST["Beschrijving"]) && isset($_POST["Startprijs"]) && isset($_FILES["img"]) && isset($_POST["Verzendinstructies"])) {
            $posts = [];
            $date = date("Y-m-d");
            foreach ($parameterList as $parameter) {
                $posts[$parameter] = (isset($_POST[$parameter])) ? $_POST[$parameter] : '';
            }
            $item = array(":Titel" => $posts["Titel"], ":Beschrijving" => $posts["Beschrijving"],
                ":Startprijs" => $posts["Startprijs"], ":Betalingswijze" => $posts["Betalingswijze"],
                ":Betalingsinstructie" => $posts["Betalingsinstructie"],
                ":Plaatsnaam" => $user["Plaatsnaam"], ":Land" => $user["Land"],
                ":Looptijd" => $posts["Looptijd"], ":LooptijdBeginDag" => $date,
                ":LooptijdBeginTijdstip" => date("H:i:s"),
                ":Verzendkosten" => 5, ":Verzendinstructies" => $posts["Verzendinstructies"], ":Verkoper" => $user["Gebruikersnaam"],
                ":LooptijdEindeDag" => date('Y-m-d', strtotime($date . ' + ' . $_POST['Looptijd'] . ' days')),
                ":LooptijdEindeTijdstip" => date("H:i:s"), ":VeilingGesloten" => "Nee", ":Verkoopprijs" => $posts["Startprijs"]);
            //if image is set
            if(isset($_FILES)){
                //try insert
                if(Items::insertItem($item)) {
                    $itemId= Items::get_ItemId();
                    Items::insertIntoRubriek($itemId,$_POST['Rubriek']);
                    // if not png
                    if ($_FILES['img']['type'] != 'image/png') {
                        //convert to png
                        imagepng(imagecreatefromstring(file_get_contents($_FILES['img']['tmp_name'])), 'upload/items/tempItem.png');
                    }
                    //store file with new autoincrementId as id.png
                    storeImg($itemId,"upload/items/");
//                    header("Location: profile.php"); // send person to his item page
                }
            }else{
                $err = "something went wrong";
            }
        } else {
            $err = "please fill in all the data!";
        }
    }
} else header("Location: profile.php?action=upgrade"); // send to verkoperworden.php

$title = "AddProduct Page";
require_once('includes/header.php');

require_once('classes/views/addProductView.php');

require_once('includes/footer.php');
