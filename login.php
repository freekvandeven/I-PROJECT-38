<?php
session_start();
require_once('includes/functions.php');
# handle the login post request
if(isset($_POST["username"]) && isset($_POST["password"])){
    echo $_POST["username"];
    $user = getUser($_POST["username"]);
    echo $user;
    if(password_verify($_POST["password"], $user['wachtwoord'])) {
        createSession($user);
        header("Location: profile.php");
    }
} else {
    echo "please fill in all the data!";
}

$title = "Login pagina";
require_once('includes/header.php');

require_once('classes/views/loginView.php');

require_once('includes/footer.php');