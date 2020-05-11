<?php
session_start();
require_once('includes/functions.php');
if(checkPost()){
    checkLogin();
    $ref = $_POST['voorwerp'];
    // Validatie verzending bod
    if(isset($_POST["bid"]) && !empty($_POST["bid"])){
        // initialisatie variabelen
        $highestBid = Items::getHighestBid($ref)['Bodbedrag'];
        $startPrijs = Items::getItem($ref)["Startprijs"];

        // bepalen van startprijs
        if($startPrijs >= 10 && $startPrijs <= 25){
            $minimumIncrease = ($highestBid / 100) * 0.028;
        } else if ($startPrijs > 25 && $startPrijs <= 50){
            $minimumIncrease = ($highestBid / 100) * 0.026;
        } else if ($startPrijs > 50 && $startPrijs <= 75){
            $minimumIncrease = ($highestBid / 100) * 0.025;
        } else if($startPrijs > 75 && $startPrijs <= 100){
            $minimumIncrease = ($highestBid / 100) * 0.021;
        } else if($startPrijs > 100 && $startPrijs < 250){
            $minimumIncrease = ($highestBid / 100) * 0.018;
        } else if($startPrijs > 250 && $startPrijs < 500){
            $minimumIncrease = ($highestBid / 100) * 0.013;
        } else if($startPrijs > 500 && $startPrijs < 750){
            $minimumIncrease = ($highestBid / 100) * 0.01;
        } else if($startPrijs > 750){
            $minimumIncrease = ($highestBid / 100) * 0.005;
        }

        if($_POST["bid"] > $highestBid && $_POST["bid"] > $startPrijs){
            if( ($_POST["bid"] - $highestBid) > $minimumIncrease){
                Items::placeBid($ref, $_POST["bid"], $_SESSION['name']);
            }
        }

    } else {
        $err = "bid is to low";
    }

    header("Location: item.php?id=$ref");
}
if(!empty($_GET) && isset($_GET['id'])) {
    $item = Items::getItem($_GET['id']);
    $profile_data = User::getUser($item['Verkoper']);
    $bids = Items::getBids($_GET['id']);
} else {
    header('Location: catalogus.php');
}

if (!empty($_POST) && isset($_POST['Verzenden'])) {
    $sent = true;
    echo 'Bedankt voor uw feedback!';
    echo "Uw beoordeling was: ";
    echo $_POST['rate'];
    Database::rateSeller($profile_data['Gebruikersnaam'], $_POST['rate']);
}

$title = "Item Page";

require_once('includes/header.php');

require_once('classes/views/itemView.php');

require_once('includes/footer.php');