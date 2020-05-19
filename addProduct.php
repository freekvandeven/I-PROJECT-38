<?php
session_start();
require_once('includes/functions.php');
checkLogin();
registerRequest();
$parameterList = array("Titel", "Beschrijving", "Rubriek", "img", "Startprijs", "Betalingswijze", "Betalingsinstructie", "Looptijd",
    "Verzendinstructies");
$user = User::getUser($_SESSION["name"]);
$maxOptionalPhotos = 5;

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
            if(isset($_FILES['thumbnail'])){
                //try insert
                if(Items::insertItem($item)) {
                    $itemId= Items::get_ItemId();
                    Items::insertIntoRubriek($itemId,$_POST['Rubriek']);
                    // if not png
                    if ($_FILES['thumbnail']['type'] != 'image/png') {
                        //convert to png
                        imagepng(imagecreatefromstring(file_get_contents($_FILES['thumbnail']['tmp_name'])), 'upload/items/tempItem.png');
                    }

                    $insertFilesArray['Filenaam'] = "$itemId.png";
                    $insertFilesArray['Voorwerp'] = $itemId;
                    if(Items::insertFiles($insertFilesArray)) {
                        //store file with new autoincrementId as id.png
                        storeImg($_FILES['thumbnail']['tmp_name'], $itemId,"upload/items/");
                    } else {
                        $err = "Er ging iets mis met de database.";
                    }

                    //If there are any optional photos added
                    if(isset($_FILES['img'])) {
                        // re-organizes array to fill the data easier
                        $optionalPhotosArray = reOrganizeArray($_FILES['img']);
                        // per photo
                        for($i=0; $i<count($optionalPhotosArray) && $i < $maxOptionalPhotos; $i++) {
                            // converts to .png
                            if ($optionalPhotosArray[$i]['type'] != 'image/png') {
                                //convert to png
                                imagepng(imagecreatefromstring(file_get_contents($_FILES['img']['tmp_name'])), 'upload/items/tempItem.png');
                            }
                            $insertFilesArray['Filenaam'] = "{$itemId}_{$i}.png";
                            $insertFilesArray['Voorwerp'] = $itemId;
                            if (Items::insertFiles($insertFilesArray)) {
                                //stores file with new autoincrementId + _$i as id_$i.png
                                storeImg($optionalPhotosArray[$i]['tmp_name'], $itemId . _ . $i, "upload/items/");
                                header("Location: item.php?id=$itemId");
                            } else {
                                $err = "Er ging iets mis met de database.";
                            }
                        }
                    }
                } else{
                    $err = "Er ging iets mis met de database.";
                }
            } else{
                $err = "Een thumbnail is verplicht!";
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
