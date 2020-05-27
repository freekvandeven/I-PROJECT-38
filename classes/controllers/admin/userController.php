<?php

# code for controlling users

if (isset($_POST['deleteUser'])) {
    User::deleteUser($_POST['deleteUser']);
    $toast = "Gebruiker succesvol verwijderd";
}
$_GET['category'] = $_POST['category'];