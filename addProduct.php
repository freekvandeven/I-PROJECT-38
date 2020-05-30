<?php
session_start();
require_once('includes/functions.php');
checkLogin();
registerRequest();

if (checkPost()) {
    $err = createProduct();
}

function createProduct()
{
    $user = User::getUser($_SESSION["name"]);
    if (!$user["Verkoper"]) header("Location:profile.php?action=upgrade&toast=je moet eerst verkoper worden");
    if (!isset($_POST["Titel"], $_POST["Beschrijving"], $_POST["Startprijs"], $_FILES["img"], $_POST["Verzendkosten"])) return "please fill in all the data!";
    if (!isset($_FILES['thumbnail'])) return "Een thumbnail is verplicht!";
    $maxOptionalPhotos = 5;
    $parameterList = array("Titel", "Beschrijving", "Rubriek", "img", "Startprijs", "Betalingswijze", "Betalingsinstructie", "Looptijd", "Verzendkosten", "Verzendinstructies");
    $posts = [];
    foreach ($parameterList as $parameter) {
        $posts[$parameter] = (isset($_POST[$parameter])) ? $_POST[$parameter] : '';
    }
    $item = array(":Titel" => $posts["Titel"], ":Beschrijving" => $posts["Beschrijving"], ":Startprijs" => $posts["Startprijs"], ":Betalingswijze" => $posts["Betalingswijze"],
        ":Betalingsinstructie" => $posts["Betalingsinstructie"], ":Plaatsnaam" => $user["Plaatsnaam"], ":Land" => $user["Land"],
        ":LooptijdBeginTijdstip" => date('Y-m-d H:i:s'), ":Verzendkosten" => $posts["Verzendkosten"], ":Verzendinstructies" => $posts["Verzendinstructies"], ":Verkoper" => $user["Gebruikersnaam"],
        ":LooptijdEindeTijdstip" => date('Y-m-d H:i:s', strTotime(' + ' . $posts["Looptijd"] . ' days')), ":VeilingGesloten" => 0, ":Verkoopprijs" => $posts["Startprijs"]);
    if (!Items::insertItem($item)) return "Er ging iets mis met de database.";
    $itemId = Items::get_ItemId();
    Category::insertIntoRubriek($itemId, $_POST['Rubriek']);

    if ($_FILES['thumbnail']['type'] != 'image/png') {
        //convert to png
        imagepng(imagecreatefromstring(file_get_contents($_FILES['thumbnail']['tmp_name'])), 'upload/items/tempItem.png');
    }
    if (Items::insertFile(array('Filenaam' => "cstimg$itemId.png", 'Voorwerp' => $itemId))) {
        storeImg($_FILES['thumbnail']['tmp_name'], "cstimg" . $itemId, "upload/items/");
    } else return "Er ging iets mis met de database.";
    if (!isset($_FILES['img'])) return "voeg wat afbeeldingen toe";
    // re-organizes array to fill the data easier
    $optionalPhotosArray = reOrganizeArray($_FILES['img']);
    for ($i = 0; $i < count($optionalPhotosArray) && $i < $maxOptionalPhotos; $i++) {
        if ($optionalPhotosArray[$i]['type'] != 'image/png') {
            //convert to png
            imagepng(imagecreatefromstring(file_get_contents($optionalPhotosArray[$i]['tmp_name'])), 'upload/items/tempItem.png');
        }
        if (Items::insertFile(array('Filenaam' => "cst{$itemId}_{$i}.png", 'Voorwerp' => $itemId))) {
            storeImg($optionalPhotosArray[$i]['tmp_name'], "cst" . $itemId . "_" . $i, "upload/items/");
        } else return "Er ging iets mis met de database.";
    }
    header("Location: item.php?id=$itemId");
}

$title = "AddProduct Page";
require_once('includes/header.php');

require_once('classes/views/addProductView.php');

require_once('includes/footer.php');