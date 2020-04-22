<?php

session_start();

$title = "inlogbeheerder";

require_once('includes/database.php');

require_once('includes/functions.php');

require_once('includes/header.php');

if (isset($_POST['submit'])) {
    $username = $_POST['username'];

    $profile_data = getUser($username);

    if( profile_data['Gebruikersnaam'] == $username && profile_data['Action'] == 1){
        header('Location: admin.php');
    } 
  }



require_once('includes/footer.php');

?>