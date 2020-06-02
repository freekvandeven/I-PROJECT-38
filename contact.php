<?php
session_start();
require_once('includes/functions.php');
registerRequest();

$title = "Contact Page";

if(checkPost() && isset($_POST['first-name'],$_POST['surname'],$_POST['email'], $_POST['message'])){
    Admin :: giveWebsiteFeedback($_POST['first-name'],$_POST['surname'],$_POST['email'], $_POST['message']);
    $toast = 'Bedankt voor het invullen van het formulier';
}

require_once 'includes/header.php';

require_once('classes/views/contactView.php');

require_once('includes/footer.php');