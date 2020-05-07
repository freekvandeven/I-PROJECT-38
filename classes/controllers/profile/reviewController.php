<?php
if(isset($_POST['user']) && !empty($_POST['user'])) {
    if (isset($_POST['review']) && !empty($_POST['review'])) {
        User::reviewUser($_POST['user'], $_SESSION['name'], $_POST['review']);
    }
    if (isset($_POST['rate']) && !empty($_POST['rate'])) {
        Database::rateSeller($_POST['user'],$_POST['rate']);
    }
    $_GET['id'] = $_POST['user'];
}