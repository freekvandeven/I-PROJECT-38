<?php
session_start();
require_once('includes/functions.php');
registerRequest();

$title = "Forgot password";

if(isset($_POST['email'])){
        if(User::validateEmail($_POST['email'])>0){
        $user = User::getUserWithEmail($_POST['email']);
        $vars['email'] = $_POST['email'];
        $vars['hash'] = hash("md5",$user['Wachtwoord']);
        $vars['username'] = $user['Voornaam'];
        sendFormattedMail($_POST['email'],"Password Reset","forgotPassword.html", $vars);
        $toast = "email is verzonden";
    }
}
if(isset($_GET['email'])&&isset($_GET['hash'])){
    $user = User::getUserWithEmail($_GET['email']);
    if($_GET['hash']==hash("md5",$user['Wachtwoord'])){
        createSession($user);
        header("Location: profile.php?action=update&toast=update je wachtwoord");
    }
}
require_once('includes/header.php');

require_once('classes/views/forgotPasswordView.php');

require_once('includes/footer.php');