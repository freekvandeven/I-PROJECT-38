<?php
session_start();
require_once('includes/functions.php');

if(!empty($_GET) && isset($_GET['id'])) {
    $item = Items::getItem($_GET['id']);
    $profile_data = User::getUser($item['Verkoper']);
} else {
    header('Location : catalogus.php');
}

$title = "Item Page";
require_once('includes/header.php');

require_once('classes/views/itemView.php');

require_once('includes/footer.php');