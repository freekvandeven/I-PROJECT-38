<?php

session_start();

$title = "toevoegenproduct";

require_once('includes/database.php');

require_once('includes/functions.php');

require_once('includes/header.php');
$parameterList = array("Titel", "Beschrijving", "Rubriek", "img", "Startprijs", "Betalingswijze", "Betalingsinstructie", "Looptijd",
    "Verzendinstructies");
checkLogin();
$user = getUser($_SESSION["name"]);
if ($user["Verkoper"] == "1") {
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
        //insert into db
        insertItem($item);
        // if not png
        if ($_FILES['img']['type'] != 'image/png') {
            //convert to png
            imagepng(imagecreatefromstring(file_get_contents($_FILES['img']['tmp_name'])), 'uploads/items/tempItem.png');
        }
        //store file with new autoincrementId as id.png
        storeImg(get_ItemId());
        header("Location: profile.php"); // send person to his item page
    } else {
        echo "please fill in all the data!";
    }
} else header("Location: profile.php"); // send to verkoperworden.php
require_once ('classes/views/addProductView.php');
require_once('includes/footer.php');
?>