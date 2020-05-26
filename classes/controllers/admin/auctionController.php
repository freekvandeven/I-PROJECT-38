<?php

# code for handling with auctions

if(isset($_POST['deleteAuction'])){
    Items::deleteItem($_POST['deleteAuction']);

}
$_GET['category'] = $_POST['category'];