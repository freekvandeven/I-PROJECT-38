<?php
session_start();
require_once('includes/functions.php');

if(!empty($_GET) && isset($_GET)['name']){
    if(User::checkRegisterUser($_GET['name']) == 0){
        User::makeUser($_GET['name']);
        createSession($_GET['name']);
        header('Location: profile.php);
    }
}

# handle the login post request
if(!empty($_POST)) {
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        $user = User::getUser($_POST["username"]);
        if (password_verify($_POST["password"], $user['Wachtwoord'])) {
            createSession($user);
            header("Location: profile.php");
        } else {
            $err = "Incorrect password";
        }
    } else {
        $err = "please fill in all the data!";
    }
}

$title = "Login pagina";
require_once('includes/header.php');

require_once('classes/views/loginView.php');

require_once('includes/footer.php');
