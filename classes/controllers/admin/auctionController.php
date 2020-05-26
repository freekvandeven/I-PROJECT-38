<?php

# code for handling with auctions

if(isset($_POST['deleteAuction'])){
    Items::deleteItem($_POST['deleteAuction']);
    $toast = "Veiling succesvol verwijderd";
}
$_GET['category'] = $_POST['category'];