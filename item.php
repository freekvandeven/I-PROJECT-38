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
            if ($startPrijs < 10) {
                $percentage = 0.03;
            } else if ($startPrijs >= 10 && $startPrijs <= 25) {
                $percentage = 0.028;
            } else if ($startPrijs > 25 && $startPrijs <= 50) {
                $percentage = 0.026;
            } else if ($startPrijs > 50 && $startPrijs <= 75) {
                $percentage = 0.025;
            } else if ($startPrijs > 75 && $startPrijs <= 100) {
                $percentage = 0.021;
            } else if ($startPrijs > 100 && $startPrijs < 250) {
                $percentage = 0.018;
            } else if ($startPrijs > 250 && $startPrijs < 500) {
                $percentage = 0.013;
            } else if ($startPrijs > 500 && $startPrijs <= 750) {
                $percentage = 0.01;
            } else if ($startPrijs > 750) {
                $percentage = 0.005;
            }

            $minimumIncrease = startPrijs * $percentage;

            if ($_POST["bid"] > $highestBid['Bodbedrag'] && $_POST["bid"] > $startPrijs) {
                if (($_POST["bid"] - $highestBid['Bodbedrag']) > $minimumIncrease) {
                    Items::placeBid($ref, $_POST["bid"], $_SESSION['name'], date('Y-m-d H:i:s'));
                    notifyFollowers($ref);
                    User::notifyUser($highestBid['Gebruiker'],"Je bent overboden");
                }
            }

        } else {
            $err = "bid is to low";
        }
    }
    header("Location: item.php?id=$ref");
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
    header('Location: catalogus.php'); // item doesn't exist
}

$title = "Item Page";

require_once('includes/header.php');

require_once('classes/views/itemView.php');

require_once('includes/footer.php');