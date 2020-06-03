<?php
session_start();
require_once('includes/functions.php');
registerRequest();

$sent = false; // no rating has been set
if(checkPost()) {
    checkLogin();
    $ref = $_POST['voorwerp'];
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'review') {
            require_once('classes/controllers/profile/reviewController.php');
        }
        if ($_POST['action'] == 'follow') {
            require_once('classes/controllers/profile/followController.php');
        }
        if ($_POST['action'] == 'raten') {
            $sent = true;
            Database::rateSeller($profile_data['Gebruikersnaam'], $_POST['rate']);
        }
        if($_POST['action'] == 'delete' && $_SESSION['admin']) {
            Items::deleteItem($ref);
        }
    } else {
        // Validatie verzending bod
        $item = Items::getItem($ref);
        if (isset($_POST["bid"]) && !empty($_POST["bid"] && $_SESSION['name'] != $item['Verkoper'])) {
            // initialisatie variabelen
            $highestBid = Items::getHighestBid($ref);
            $startPrijs = Items::getItem($ref)["Startprijs"];

            // bepalen van startprijs
            $percentage = 0.01;
            $minimumIncrease = $startPrijs * $percentage;

            // het bieden
            if ($_POST["bid"] > $highestBid['Bodbedrag'] && $_POST["bid"] > $startPrijs) {
                if (($_POST["bid"] - $highestBid['Bodbedrag']) > $minimumIncrease) {
                    Items::placeBid($ref, $_POST["bid"], $_SESSION['name'], date('Y-m-d H:i:s'));
                    notifyFollowers($ref, "Er is geboden op de veiling");
                    User::notifyUser($highestBid['Gebruiker'],"Je bent overboden", "item.php?id=$ref");
                    $toast = "U heeft succesvol geboden";
                    $succes = "U heeft succesvol geboden";
                } else {
                    $toast = "Bod moet minimaal €".number_format($minimumIncrease, 2)." hoger zijn dan de startprijs/hoogste bod";
                    $err = "Bod moet minimaal €".number_format($minimumIncrease, 2)." hoger zijn dan de startprijs/hoogste bod";
                }
            } else {
                $toast = "Bod moet minimaal €".number_format($minimumIncrease, 2)." hoger zijn dan de startprijs/hoogste bod";
                $err = "Bod moet minimaal €".number_format($minimumIncrease, 2)." hoger zijn dan de startprijs/hoogste bod";
            }

        } else {
            $toast = "U kunt niet bieden op uw eigen veiling";
            $err = "Het is niet toegestaan om op uw eigen veiling te bieden";
        }
    }
    if(isset($succes)) header("Location: item.php?id=$ref&toast=$toast&succes=$succes");
    else header("Location: item.php?id=$ref&toast=$toast&err=$err");
}
if(!empty($_GET) && isset($_GET['id'])) {
    $item = Items::getItem($_GET['id']);
    if(!empty($item)) {
        $profile_data = User::getUser($item['Verkoper']);
        $bids = Items::getBids($_GET['id']);
        if($item['Verkoper']!=$_SESSION['name'])
        Items::addView($_GET['id']);
    }
} else {
    header('Location: catalogus.php?toast=veiling bestaat niet'); // item doesn't exist
}

$title = "Item Page";

require_once('includes/header.php');

require_once('classes/views/itemView.php');

require_once('includes/footer.php');