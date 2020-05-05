<?php
session_start();
require_once('includes/functions.php');
if(!empty($_POST)){
    checkLogin();
    $ref = $_POST['voorwerp'];
    if(isset($_POST["bid"]) && !empty($_POST["bid"])){
        if($_POST["bid"] > Items::getHighestBid($ref) && $_POST["bid"] > Items::getItem($ref)["Startprijs"]){
            Items::placeBid($ref, $_POST["bid"], $_SESSION['name']);
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

$title = "Item Page";
require_once('includes/header.php');

require_once('classes/views/itemView.php');

require_once('includes/footer.php');